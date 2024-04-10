<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Proveedore;
use App\Models\Compra;
use App\Models\Venta;



/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->expectsJson()) {
        $productos = Producto::all();
        return response()->json(['productos' => $productos], 200);
      } else {
        $productos = Producto::paginate();

        return view('producto.index', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        
    
        return view('producto.create', compact('producto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'idReferencia' => 'required|string|min:1|max:20|unique:productos,idReferencia',
          'nombreProducto' => 'required|string|min:3|max:30',
          'Talla' => 'required|string',
          'Cantidad' => 'required|integer|min:1|max:999999999',
          'Categoria' => 'required|string',
          'Precio' => 'required|integer|min:1|max:999999999',
          'Foto' => 'image|mimes:jpeg,png,jpg|max:1048' // Asegura que el archivo sea una imagen válida y no supere los 2MB
      ]);

      try {
        $producto = new Producto();
        $producto->idReferencia = $request->idReferencia;
        $producto->nombreProducto = $request->nombreProducto;
        $producto->Talla = $request->Talla;
        $producto->Cantidad = $request->Cantidad;
        $producto->Categoria = $request->Categoria;
        $producto->Precio = $request->Precio;

        if ($request->hasFile('Foto')) {
            $file = $request->file('Foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products/'), $filename);
            $producto->Foto = $filename;
        }

        $producto->save();

        // Verificar si es una solicitud ajax
        if ($request->ajax() || $request->expectsJson()) {
          $productos = Producto::all();
          return response()->json(['success' => '¡Producto creado con exito!', 'productos' => $productos], 200);
        } else {
            return redirect()->route('productos.index')
                ->with('success', '¡Producto creado con exito!');
        }
      } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
      }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
    
        return view('producto.edit', compact('producto'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
      $request->validate([
        'idReferencia' => 'required|string|min:1|max:20|unique:productos,idReferencia,'.$producto->idReferencia.',idReferencia',
          'nombreProducto' => 'required|string|min:3|max:30',
          'Talla' => 'required|string',
          'Cantidad' => 'required|integer|min:1|max:999999999',
          'Categoria' => 'required|string',
          'Precio' => 'required|numeric|min:0|max:999999999',
          'Foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Asegura que el archivo sea una imagen válida y no supere los 2MB
      ]);
    
      try {
          $producto->update([
              'idReferencia' => $request->idReferencia,
              'nombreProducto' => $request->nombreProducto,
              'Talla' => $request->Talla,
              'Cantidad' => $request->Cantidad,
              'Categoria' => $request->Categoria,
              'Precio' => $request->Precio,
          ]);

          if ($request->hasFile('Foto')) {
              $file = $request->file('Foto');
              $filename = time() . '.' . $file->getClientOriginalExtension();
              $file->move(public_path('images/products/'), $filename);
              $producto->Foto = $filename;
              $producto->save();
          }

          // Verificar si es una solicitud ajax
          if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => '¡Producto editado con exito!'], 200);
          } else {
            return redirect()->route('productos.index')
                ->with('success', '¡Producto editado con éxito!');
          }
      } catch (\Exception $e) {
          return redirect()->back()->withInput()->with('error', $e->getMessage());
      }
    }



    /**
     * Update the stock of a product.
     *
     * @param  int      $productId  The ID of the product.
     * @param  int      $quantity   The quantity to add or subtract from the stock.
     * @param  string   $action     The action to perform ('add' or 'subtract').
     * @return void
     */
    public function updateStock($idReferencia, $quantity, $action='add')
    {
        $product = Producto::where('idReferencia', $idReferencia)->first();
    
        // Verificar si el producto existe
        if (!$product) {
            throw new \Exception('Producto no encontrado.');
        }
    
        // Actualizar el stock según la acción (add o subtract)
        if ($action === 'subtract') {
            $product->Cantidad -= $quantity;
        } else {
            $product->Cantidad += $quantity;
        }
    
        // Guardar los cambios en la base de datos
        $product->save();
    }
    


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            
            // Verificar si el producto tiene ventas o compras asociadas
            if ($producto->ventas()->exists() || $producto->compras()->exists()) {
                throw new \Exception('No se puede eliminar el producto porque tiene ventas o compras asociadas.');
            }

            $producto->delete();

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => '¡Producto eliminado con éxito!'], 200);
            } else {
                return redirect()->route('productos.index')->with('success', '¡Producto eliminado con éxito!');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['error' => $errorMessage], 200);
            } else {
                return redirect()->route('productos.index')->with('error', $errorMessage);
            }
        }
    }

}
