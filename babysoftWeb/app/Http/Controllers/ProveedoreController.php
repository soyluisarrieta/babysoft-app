<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Compra;

class ProveedoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedore::paginate();

        return view('proveedore.index', compact('proveedores'))
            ->with('i', (request()->input('page', 1) - 1) * $proveedores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fechaActual = Carbon::now()->toDateString();
        $proveedore = new Proveedore();
        
        return view('proveedore.create', compact('proveedore', 'fechaActual'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate(Proveedore::rules());

        try {
            $proveedore = Proveedore::create($validatedData);
            return redirect()->route('proveedores.index')->with('success', '¡Proveedor creado con éxito!');
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
        $proveedore = Proveedore::findOrFail($id);

        return view('proveedore.show', compact('proveedore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedore = Proveedore::findOrFail($id);
        $fechaActual = Carbon::now()->toDateString();

        return view('proveedore.edit', compact('proveedore','fechaActual'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Proveedore $proveedore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedore $proveedore)
    {
      $validatedData = $request->validate(
          Proveedore::rules($proveedore->idProveedor)
      );
      try {
        $proveedore->update($validatedData);

        return redirect()->route('proveedores.index')->with('success', '¡Proveedor editado con éxito!');
      } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedore = Proveedore::findOrFail($id);

        // Verificar si hay compras asociadas al proveedor
        if ($proveedore->compras()->exists()) {
            return redirect()->route('proveedores.index')
                ->with('error', '¡No puedes eliminar este proveedor porque tiene compras asociadas!');
        }

        // Si no hay compras asociadas, procede a eliminar el proveedor
        $proveedore->delete();

        return redirect()->route('proveedores.index')
            ->with('success', '¡Proveedor eliminado con éxito!');
    }

}
