@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title" class="text-center" style="font-size: 28px; font-weight: bold;">
                                {{ __('Editar Usuario') }}
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
                        <form id="form" class="formulario-editar" method="POST" action="{{ route('usuarios.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group" onkeypress="return sololetras(event)">
                                {{ Form::label('name', 'Nombre Completo:') }}
                                {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 
                                  'required', 
                                  'minlength' => '3', 
                                  'maxlength' => '30'
                                ]) }}
                                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                          
                            <div class="form-group">
                                {{ Form::label('email', 'Email:') }}
                                {{ Form::email('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 
                                    'required', 
                                    'minlength' => '5', 
                                    'maxlength' => '30'
                                  ]) }}
                                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group">
                                {{ Form::label('roles', 'Roles:') }}
                                @foreach ($roles as $role)
                                    <div>
                                        {{ Form::checkbox('roles[]', $role->name, $user->hasRole($role->name), ['id' => 'role_' . $role->id]) }}
                                        {{ Form::label('role_' . $role->id, $role->name) }}
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    {{ Form::checkbox('isActived', 1, $user->isActived, ['class' => 'custom-control-input', 'id' => 'isActived']) }}
                                    {{ Form::label('isActived', 'Usuario habilitado', ['class' => 'custom-control-label']) }}
                                </div>
                            </div>

                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>ㅤ{{ __('Volver') }}</a>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validarNumero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 8) return true;
            patron = /[0-9]/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }

        function sololetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = "àèìòùabcdefghijklmnñopqrstuvwxyz";
            especiales = "8-37-38-46-164";

            // Permitir espacio solo si el último caracter no es un espacio
            if (tecla == ' ' && this.value.slice(-1) == ' ') {
                return false;
            }

            tecla_especial = false;
            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }

            // Asegurarse de que solo se permita un espacio entre palabras
            if (tecla == ' ') {
                setTimeout(() => {
                    let newStr = this.value.trim().split(/[\s,\t,\n]+/).join(' ');
                    this.value = newStr;
                }, 0);
            }
        }










        document.getElementById('form').addEventListener('submit', function(event) {
            var correo = document.getElementById('email').value;
            if (!validarCorreoElectronico(correo)) {
                event.preventDefault(); // Evitar que se envíe el formulario
            }
        });

        function validarCorreoElectronico(correo) {
            // Expresión regular para validar el formato de correo electrónico
            var patron = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return patron.test(correo);
        }
    </script>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.formulario-editar').submit(function(e){
            e.preventDefault();

            Swal.fire({
                title: '¿Quieres editar este usuario?',
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
                }
            });
        });
    </script>
@stop
