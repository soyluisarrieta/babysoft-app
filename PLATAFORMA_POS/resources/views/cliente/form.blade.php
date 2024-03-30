<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group" onkeypress="return validarNumero(event)" required>
            {{ Form::label('Número Identidad') }}
            {{ Form::text('numeroIdentificacion', $cliente->numeroIdentificacion, ['class' => 'form-control' . ($errors->has('numeroIdentificacion') ? ' is-invalid' : ''),
                'required',
                'minlength' => '10',
                'maxlength' => '10',
            ]) }}
            {!! $errors->first('numeroIdentificacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group" onkeypress="return sololetras(event)" required>
            {{ Form::label('Nombre') }}
            {{ Form::text('Nombre', $cliente->Nombre, ['class' => 'form-control' . ($errors->has('Nombre') ? ' is-invalid' : ''),
                'required',
                'minlength' => '3',
                'maxlength' => '30',
            ]) }}
            {!! $errors->first('Nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group" onkeypress="return sololetras(event)" required>
            {{ Form::label('Apellido') }}
            {{ Form::text('Apellido', $cliente->Apellido, ['class' => 'form-control' . ($errors->has('Apellido') ? ' is-invalid' : ''),
                'required',
                'minlength' => '3',
                'maxlength' => '30',
            ]) }}
            {!! $errors->first('Apellido', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group" required>
            {{ Form::label('Email') }}
            {{ Form::email('Email', $cliente->Email, ['class' => 'form-control' . ($errors->has('Email') ? ' is-invalid' : ''),
                'required',
                'minlength' => '5',
                'maxlength' => '30',
            ]) }}
            {!! $errors->first('Email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group" onkeypress="return validarNumero(event)" required>
            {{ Form::label('Teléfono') }}
            {{ Form::text('Telefono', $cliente->Telefono, ['class' => 'form-control' . ($errors->has('Telefono') ? ' is-invalid' : ''),
                'required',
                'minlength' => '10',
                'maxlength' => '10',
            ]) }}
            {!! $errors->first('Telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="float-right">
        <a class="btn btn-primary" href="{{ route('clientes.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>ㅤ{{ __('Volver') }}</a>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>ㅤ{{ __('Guardar') }}</button>
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
        letras = "àèìòùabcdefghijklmnñopqrstuvwxyz ";
        especiales = "8-37-38-46-164";

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
    }


    document.getElementById('form').addEventListener('submit', function(event) {
        var correo = document.getElementById('email').value;
        if (!validarCorreoElectronico(correo)) {
            alert('Correo electrónico inválido');
            event.preventDefault(); // Evitar que se envíe el formulario
        }
    });

    function validarCorreoElectronico(correo) {
        // Expresión regular para validar el formato de correo electrónico
        var patron = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return patron.test(correo);
    }
</script>