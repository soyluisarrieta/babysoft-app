@extends('adminlte::page')

@section('template_title')
    {{ $venta->name ?? __('Show Venta') }}
@endsection

@section('content')
    <section class="content container-fluid" style="max-width: 600px; padding-top:40px">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title" style="font-size: 25px; font-weight: bold;">
                                Detalles de la venta
                            </span>
                        </div>

                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('ventas.index') }}">{{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col">
                                <span class="text-muted d-block">Cliente</span>
                                <strong class="h3">{{ $clientes[$venta->idCliente] }}</strong>
                            </div>
                            <div class="form-group col-2 text-right">
                                <strong class="h3">ID-{{ $venta->idVenta }}</strong>
                                <small class="h6 d-block">{{ $venta->Fecha }}</small>
                            </div>
                        </div>

                        <h4 class="border-bottom mt-2 mb-3" style="font-weight: bold;">Productos Vendidos</h4>

                        <div class="detalle-venta" style="font-size: 15px;">
                            <div class="row align-items-center">
                                <div class="col-7 text-muted">Nombre del Producto</div>
                                <div class="col-2 text-muted" align="center">Cantidad</div>
                                <div class="col text-muted" align="right">Subtotal</div>
                            </div>
                            @foreach ($detalles_venta as $detalle)
                                <div class="row align-items-center">
                                    <div class="col-7 h5 mt-1">{{ $detalle->producto->nombreProducto ?? 'Producto no encontrado' }}</div>
                                    <div class="col-2 h5 mt-1" align="center">{{ $detalle->Cantidad }}</div>
                                    <div class="col h5 mt-1 justify-content-center" align="right">${{ $detalle->Subtotal }}</div>
                                </div>
                            @endforeach
                            <div class="border-top mt-2 pt-2" align="right">
                              <strong class="h4 text-bold">${{ $venta->ValorTotal }}<strong>
                              <small class="text-muted d-block text-sm">Valor total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
