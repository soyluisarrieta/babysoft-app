<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
  public function index()
  {
    $ventas = Venta::paginate();
    $detallesVentas = DetalleVenta::paginate();
    $clientes = Cliente::select('idCliente', 'Nombre', 'Apellido')->get()
      ->map(function ($cliente) {
        return [
          'id' => $cliente->idCliente,
          'nombre_completo' => $cliente->Nombre . ' ' . $cliente->Apellido,
        ];
      })
      ->pluck('nombre_completo', 'id')
      ->toArray();
    $productos = Producto::pluck('nombreProducto', 'idReferencia')->toArray();

    return view('venta.index', compact('ventas', 'detallesVentas', 'clientes', 'productos'))
      ->with('i', (request()->input('page', 1) - 1) * $ventas->perPage());
  }

  public function create()
  {
    $fechaActual = Carbon::now()->toDateString();

    $venta = new Venta();
    $usuarios = User::all();
    $producto = new Producto();
    $productos = Producto::all();
    $clientes = Cliente::select('idCliente', 'Nombre', 'Apellido')->get()
      ->map(function ($cliente) {
        return [
          'id' => $cliente->idCliente,
          'nombre_completo' => $cliente->Nombre . ' ' . $cliente->Apellido,
        ];
      })
      ->pluck('nombre_completo', 'id')
      ->toArray();

    $detalleVenta = new DetalleVenta();

    return view('venta.create', compact('venta', 'fechaActual', 'usuarios', 'productos', 'producto', 'clientes', 'detalleVenta'));
  }

  public function store(Request $request)
  {
      // Validación de los datos del formulario
      $request->validate([
        'idCliente' => 'required|exists:clientes,idCliente',
        'ValorTotal' => 'required|numeric|min:0|max:9999999999',
        'Fecha' => 'required|date',
        'idReferencia' => ($request->input('detallesVenta') === null ? 'required' : 'nullable'). '|exists:productos,idReferencia', 
        'Cantidad' => [
          ($request->input('idReferencia') === null ? 'nullable' : 'required'),
          'integer',
          'min:1',
          'max:9999999999',
          function ($attribute, $value, $fail) use ($request) {
              if ($request->input('idReferencia') !== null) {
                  $producto = Producto::where('idReferencia', $request->input('idReferencia'))->first();
                  $stockActual = $producto->Cantidad;
                  if ($stockActual < $value) {
                    if ($stockActual === 0) {
                      $fail("El producto \"$producto->nombreProducto\" no cuenta con ningún producto disponible en stock.");
                    } else {
                      $fail("El producto \"$producto->nombreProducto\" solo tiene disponible $stockActual en stock.");
                    }
                    return;
                  }
              }
          },
        ],
        'Subtotal' => ($request->input('Cantidad') === null ? 'nullable' : 'required'). '|integer|min:0|max:9999999999',
        'detallesVenta' => [
            'nullable',
            function ($attribute, $value, $fail) {
                $detalles = json_decode($value, true);
    
                if (!is_array($detalles)) {
                    $fail('Formato de venta inválido, reinicie la página y vuelva a intentarlo.');
                    return;
                }
    
                foreach ($detalles as $index => $detalle) {
                    $validator = Validator::make($detalle, [
                      'idReferencia' => 'required|exists:productos,idReferencia',
                      'Cantidad' => 'required|integer|min:0|max:9999999999',
                      'Subtotal' => 'required|numeric|min:0|max:9999999999',
                    ]);
    
                    if ($validator->fails()) {
                        $errors = $validator->errors()->all();
                        foreach ($errors as $error) {
                            $fail("Error en el producto #".($index+1)." ($detalle[nombreProducto]): $error");
                        }
                        return;
                    }

                    $producto = Producto::where('idReferencia', $detalle['idReferencia'])->first();
                    $stockActual = $producto->Cantidad;
                    if ($stockActual < intval($detalle['Cantidad'])) {
                      if ($stockActual === 0) {
                        $fail("El producto \"$producto->nombreProducto\" no cuenta con ningún producto disponible en stock.");
                      } else {
                        $fail("El producto \"$producto->nombreProducto\" solo tiene disponible $stockActual en stock.");
                      }
                      return;
                    }
                  }
            },
        ],
      ]);

    try {
      
      // Crear una nueva venta
      $venta = Venta::create([
        'idCliente' => $request->input('idCliente'),
        'ValorTotal' => $request->input('ValorTotal'),
        'Fecha' => $request->input('Fecha'),
        // Agrega más campos según tu estructura de tabla
      ]);

      $productController = new ProductoController();

      // Guardar detalle de la venta (Dentro del formulario)
      if ($request->input('idReferencia')) {
        DetalleVenta::create([
          'idVenta' => $venta->idVenta,
          'idReferencia' => $request->input('idReferencia'),
          'Cantidad' => $request->input('Cantidad'),
          'Subtotal' => $request->input('Subtotal'),
        ]);
        $productController->updateStock($request->input('idReferencia'),  $request->input('Cantidad'), 'subtract');
      }

      // Decodificar los detalles de la venta
      $detalles = json_decode($request->input('detallesVenta'), true);

      // Verificar si todo está vacío
      if (!$request->input('idReferencia') && empty($detalles)) {
        return redirect()->back()->with('error', 'No puedes finalizar una venta si todos los campos están vacíos.');
      }

      // Guardar los detalles de la venta
      if ($detalles) {
        foreach ($detalles as $detalle) {
          DetalleVenta::create([
            'idVenta' => $venta->idVenta,
            'idReferencia' => $detalle['idReferencia'],
            'Cantidad' => $detalle['Cantidad'],
            'Subtotal' => $detalle['Subtotal'],
            // Agrega más campos según tu estructura de tabla
          ]);
          $productController->updateStock($detalle['idReferencia'],  $detalle['Cantidad'], 'subtract');
        }
      }

      // Todo se ha guardado correctamente
      return redirect()->route('ventas.index')->with('success', '¡Venta creada con éxito!');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
  }


  public function show($id) {
    $venta = Venta::find($id);
    $detalles_venta = DetalleVenta::where('idVenta', $id)->get();

    $clientes = Cliente::select('idCliente', 'Nombre', 'Apellido')->get()
        ->map(function ($cliente) {
            return [
                'id' => $cliente->idCliente,
                'nombre_completo' => $cliente->Nombre . ' ' . $cliente->Apellido,
            ];
        })
        ->pluck('nombre_completo', 'id')
        ->toArray();


    return view('venta.show', compact('venta', 'detalles_venta', 'clientes'));
  }







}
