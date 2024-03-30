@extends('adminlte::page')

@section('template_title')
    {{ $producto->name ?? "{{ __('Show') Producto" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title" style="font-size: 25px; font-weight: bold;">
                                {{ __('Ver Producto') }}
                            </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('productos.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Referencia:</strong>
                            {{ $producto->idReferencia }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre Producto:</strong>
                            {{ $producto->nombreProducto }}
                        </div>
                        <div class="form-group">
                            <strong>Tallas:</strong>
                            {{ $producto->Talla }}
                        </div>
                        <div class="form-group">
                            <strong>Cantidad:</strong>
                            {{ $producto->Cantidad }}
                        </div>
                        <div class="form-group">
                            <strong>Categoría:</strong>
                            {{ $producto->Categoria }}
                        </div>
                        <div class="form-group">
                            <strong>Precio:</strong>
                            {{ $producto->Precio }}
                        </div>
                        <div class="form-group">
                            <strong>Foto del Producto:</strong>
                              <div>
                                <img src="{!! $producto->Foto ? asset("images/products/$producto->Foto") : asset("images/placeholders/product-placeholder.png") !!}" alt="Imagen Producto" style="max-height: 200px">
                              </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
