@extends('adminlte::page')


@section('template_title')
    {{ __('Crear Rol') }} Cliente
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" class="text-center" style="font-size: 28px; font-weight: bold;">
                            {{ __('Editar Rol') }}
                        </span>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <form id="form" class="formulario-editar" method="POST" action="{{ route('roles.update', $role->id) }}" required>
                        @csrf
                        @method('PUT')

                       

                        <div class="form-group">
                          {{ Form::label('name', 'Nombre Del Rol:') }}
                          {{ Form::text('name', $role->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required', 'minlength' => '3', 'maxlength' => '150']) }}
                          {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                      </div>
                      
                        <h2 class="h3">Lista de Permisos</h2>

                        <div class="row">
                            @foreach ($permisos as $permiso)
                                <div class="col-md-6">
                                    {!! Form::checkbox('permisos[]', $permiso->id, $role->permissions->contains($permiso->id), ['class' => '']) !!}
                                    {{ $permiso->name }}
                                </div>
                            @endforeach
                        </div>    
                        <br>

                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>ㅤ{{ __('Volver') }}</a>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>ㅤActualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')

<style>
        /* Estilos para el formulario */
        .formulario-editar {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Estilos para los campos de texto */
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        /* Estilos para los botones */
        .btn {
            padding: 8px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.formulario-editar').submit(function(e){
            e.preventDefault();
  
        Swal.fire({
        title: '¿Quieres EDITAR este rol?',
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