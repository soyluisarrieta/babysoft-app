@extends('adminlte::page')

@section('template_title')
    {{ $compra->name ?? __('Show Compra') }}
@endsection

@section('content')
    <section class="content container-fluid" style="max-width: 600px; padding-top:40px">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title" style="font-size: 25px; font-weight: bold;">
                                Detalles de la Compra
                            </span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('compras.index') }}">{{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col">
                                <span class="text-muted d-block">Proveedor</span>
                                <strong class="h3">{{ $proveedores[$compra->idProveedor] }}</strong>
                            </div>
                            <div class="form-group col-2 text-right">
                                <strong class="h3">ID-{{ $compra->idCompra }}</strong>
                                <small class="h6 d-block">{{ $compra->Fecha }}</small>
                            </div>
                        </div>

                        <hr>

                        <h4 style="font-weight: bold;">Productos Comprados</h4>

                        <div class="detalle-venta" style="font-size: 15px;">
                            <div class="row align-items-center">
                                <div class="col-7 text-muted">Nombre del Producto</div>
                                <div class="col-2 text-muted" align="center">Cantidad</div>
                                <div class="col text-muted" align="right">Subtotal</div>
                            </div>
                            @foreach ($detalles_compra as $detalle)
                                <div class="row align-items-center">
                                    <div class="col-7 h5 mt-1">{{ $detalle->producto->nombreProducto ?? 'Producto no encontrado' }}</div>
                                    <div class="col-2 h5 mt-1" align="center">{{ $detalle->Cantidad }}</div>
                                    <div class="col h5 mt-1 justify-content-center" align="right">${{ number_format($detalle->Subtotal, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                            <div class="border-top mt-2 pt-2" align="right">
                              <strong class="h4 text-bold">
                                @if($compra->Anulado) <span class="badge badge-secondary" style="vertical-align: middle; font-size: 12px;">Anulado</span> @endif
                                <span @if($compra->Anulado) style="text-decoration: line-through; opacity: 0.8;" @endif>${{ number_format($compra->ValorTotal, 0, ',', '.') }}</span>
                              <strong>
                              <small class="text-muted d-block text-sm">Total Pago</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
