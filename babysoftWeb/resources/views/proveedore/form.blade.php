<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group" onkeypress="return validarNumero(event)" required>
            {{ Form::label('Cédula /  NIT') }}
            {{ Form::text('Cedula', $proveedore->Cedula, ['class' => 'form-control' . ($errors->has('Cedula') ? ' is-invalid' : ''),
              'required',
              'minlength' => '5',
              'maxlength' => '15',
            ]) }}
            {!! $errors->first('Cedula', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group" onkeypress="return sololetras(event)">
          {{ Form::label('Nombre Proveedor') }}
          {{ Form::text('NombreProveedor', $proveedore->NombreProveedor, [
              'class' => 'form-control' . ($errors->has('NombreProveedor') ? ' is-invalid' : ''),
              'required',
              'minlength' => '3',
              'maxlength' => '30',
          ]) }}
          {!! $errors->first('NombreProveedor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group">
            {{ Form::label('Correo') }}
            {{ Form::email('Correo', $proveedore->Correo, [
                'class' => 'form-control' . ($errors->has('Correo') ? ' is-invalid' : ''),
                'required',
                'minlength' => '5',
                'maxlength' => '30'
            ]) }}
            {!! $errors->first('Correo', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
          {{ Form::label('Celular') }}
          {{ Form::text('Telefono', $proveedore->Telefono, [
              'class' => 'form-control' . ($errors->has('Telefono') ? ' is-invalid' : ''),
              'onkeypress' => 'return validarNumero(event)',
              'minlength' => '10',
              'maxlength' => '10',
              'required',
          ]) }}
          {!! $errors->first('Telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Fecha') }}
            {{ Form::date('Fecha', $fechaActual, [
                'class' => 'form-control' . ($errors->has('Fecha') ? ' is-invalid' : ''),
                'placeholder' => 'Fecha',
                'required',
                'readonly',
                'min' => now()->subDays(20)->format('Y-m-d'), // Restringe la fecha mínima 20 días en el pasado
                'max' => now()->format('Y-m-d') // Restringe la fecha máxima a la fecha actual
            ]) }}
            {!! $errors->first('Fecha', '<div class="invalid-feedback">:message</div>') !!}
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