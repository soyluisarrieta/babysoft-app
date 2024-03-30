@extends('adminlte::page')

@section('template_title')
    {{ __('Update') }} Producto
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title" style="font-size: 25px; font-weight: bold;">
                            {{ __('Editar Producto') }}
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" class="formulario-editar" action="{{ route('productos.update', $producto->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('producto.form')

                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('productos.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>ㅤ{{ __('Volver') }}</a>
                            </div>
                            <div class="box-footer mt20">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>ㅤ{{ __('Actualizar') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.formulario-editar').submit(function(e){
            e.preventDefault();
  
        Swal.fire({
        title: '¿Quieres EDITAR este producto?',
        text: "Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
            // Swal.fire(
            // 'Exito!',
            // 'Copia de Seguridad generada.',
            // 'success'
            // )
        }
        })

        });
    </script>
@stop