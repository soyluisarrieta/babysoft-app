@extends('adminlte::page')

@section('template_title')
    {{ $proveedore->name ??  __('Show') }} Proveedores
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                        <span class="card-title" style="font-size: 25px; font-weight: bold;">
                            {{ __('Ver Proveedor') }}
                        </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('proveedores.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>ID Proveedor:</strong>
                            {{ $proveedore->idProveedor }}
                        </div>
                        <div class="form-group">
                            <strong>Cédula:</strong>
                            {{ $proveedore->Cedula }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre Proveedor:</strong>
                            {{ $proveedore->NombreProveedor }}
                        </div>
                        <div class="form-group">
                            <strong>Correo:</strong>
                            {{ $proveedore->Correo }}
                        </div>
                        <div class="form-group">
                            <strong>Celular:</strong>
                            {{ $proveedore->Telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $proveedore->Fecha }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
