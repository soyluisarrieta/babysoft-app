@extends('adminlte::page')

@section('template_title')
    {{ $cliente->name ?? __('Show') }} Cliente
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title" style="font-size: 25px; font-weight: bold;">
                                {{ __('Ver Cliente') }}
                            </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('clientes.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Número Identidad:</strong>
                            {{ $cliente->numeroIdentificacion }}
                        </div>

                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $cliente->Nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Apellido:</strong>
                            {{ $cliente->Apellido }}
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $cliente->Email }}
                        </div>
                        <div class="form-group">
                            <strong>Teléfono:</strong>
                            {{ $cliente->Telefono }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

