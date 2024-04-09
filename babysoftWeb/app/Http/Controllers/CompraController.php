<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Producto;
use App\Models\Proveedore;

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Validator;

class CompraController extends Controller
{
  public function index()
  {
    $compras = Compra::paginate();
    $detallesCompras = DetalleCompra::paginate();
    $proveedores = Proveedore::select('idProveedor', 'NombreProveedor')->get()
      ->map(function ($proveedor) {
        return [
          'id' => $proveedor->idProveedor,
          'nombre_completo' => $proveedor->NombreProveedor,
        ];
      })
      ->pluck('nombre_completo', 'id')
      ->toArray();
    $productos = Producto::pluck('nombreProducto', 'idReferencia')->toArray();

    return view('compra.index', compact('compras', 'proveedores', 'detallesCompras', 'productos'))
      ->with('i', (request()->input('page', 1) - 1) * $compras->perPage());
  }

  public function create()
  {
    $fechaActual = Carbon::now()->toDateString();

    $compra = new Compra();
    $productos = Producto::all();
    $producto = new Producto();
    $proveedores = Proveedore::select('idProveedor', 'NombreProveedor')->get()
      ->map(function ($proveedor) {
        return [
          'id' => $proveedor->idProveedor,
          'nombre_completo' => $proveedor->NombreProveedor,
        ];
      })
      ->pluck('nombre_completo', 'id')
      ->toArray();

    $detalleCompra = new DetalleCompra();

    return view('compra.create', compact('compra', 'fechaActual', 'productos', 'producto', 'proveedores', 'detalleCompra'));
  }

  public function store(Request $request)
  {
    
    $request->validate([
      'idProveedor' => 'required|numeric|min:0|max:9999999999',
      'ValorTotal' => 'required|numeric|min:0|max:9999999999',
      'Fecha' => 'required|date',
      'idReferencia' => ($request->input('detallesCompra') === null ? 'required' : 'nullable'). '|exists:productos,idReferencia', // Verifica si el idReferencia existe en la tabla productos
      'Cantidad' => ($request->input('idReferencia') === null ? 'nullable' : 'required'). '|integer|min:1|max:9999999999',
      'Subtotal' =>  ($request->input('Cantidad') === null ? 'nullable' : 'required'). '|numeric|min:0|max:9999999999',
      'detallesCompra' => [
        'nullable',
        function ($attribute, $value, $fail) {
          $detalles = json_decode($value, true);
          if (!is_array($detalles)) {
            $fail('Formato de compra inválido, reinicie la página y vuelva a intentarlo.');
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
          }
        },
      ],
    ]);

    try{

      // Crear una nueva compra
      $compra = Compra::create([
        'idProveedor' => $request->input('idProveedor'),
        'ValorTotal' => $request->input('ValorTotal'),
        'Fecha' => $request->input('Fecha'),
      ]);

      $productController = new ProductoController();

      // Guardar detalle de la compra (Dentro del formulario)
      if ($request->input('idReferencia')) {
          DetalleCompra::create([
          'idCompra' => $compra->idCompra,
          'idReferencia' => $request->input('idReferencia'),
          'Cantidad' => $request->input('Cantidad'),
          'Subtotal' => $request->input('Subtotal'),
          ]);
          $productController->updateStock($request->input('idReferencia'),  $request->input('Cantidad'), 'add');
      }
      
      // Decodificar los detalles de la compra
      $detalles = json_decode($request->input('detallesCompra'), true);

      // Verificar si todo está vacío
      if (!$request->input('idReferencia') && empty($detalles)) {
        return redirect()->back()->with('error', 'No puedes finalizar una compra si todos los campos están vacíos.');
      }

      // Guardar los detalles de la compra
      if ($detalles) {
          foreach ($detalles as $detalle) {
            DetalleCompra::create([
                'idCompra' => $compra->idCompra,
                'idReferencia' => $detalle['idReferencia'],
                'Cantidad' => $detalle['Cantidad'],
                'Subtotal' => $detalle['Subtotal'],
            ]);
            $productController->updateStock($detalle['idReferencia'], $detalle['Cantidad'], 'add');
          }
      }
    

      // Todo se ha guardado correctamente
      return redirect()->route('compras.index')
        ->with('success', '¡Compra creada con éxito!');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
  }




  public function show($id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return abort(404, 'Compra no encontrada');
        }

        $proveedores = Proveedore::pluck('nombreProveedor', 'idProveedor')->toArray();

        $detalles_compra = DetalleCompra::where('idCompra', $id)->get();
        
        foreach ($detalles_compra as $detalle) {
            $detalle->producto; // Cargar la relación 'producto' para cada detalle
        }

        return view('compra.show', compact('compra', 'proveedores', 'detalles_compra'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
      try {
          $compra = Compra::findOrFail($id);
          $compra->detalles_compra()->delete();
          $compra->delete();
          return redirect()->route('compras.index')->with('success', '¡Compra y sus detalles eliminados con éxito!');
      } catch (\Exception $e) {
          $errorMessage = $e->getMessage();
          return redirect()->route('compras.index')->with('error', $errorMessage);
      }
    }
}
