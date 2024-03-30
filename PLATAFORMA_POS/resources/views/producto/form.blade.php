@php
    $proveedores = isset($proveedores) ? $proveedores : [];
@endphp

<style>
  #preview-image {
    width: 200px;
    height: 200px;
    border: dashed 2px rgb(0 0 0 / 20%);
    padding: 3px;
    object-fit: cover;
    cursor:crosshair;
  }
</style>

<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group" onkeypress="return validarEntrada(event)">
            {{ Form::label('Referencia') }}
            {{ Form::text('idReferencia', $producto->idReferencia, ['class' => 'form-control' . ($errors->has('idReferencia') ? ' is-invalid' : ''),
                'required',
                'minlength' => '1',
                'maxlength' => '20',
            ]) }}
            {!! $errors->first('idReferencia', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group" onkeypress="return sololetras(event)">
            {{ Form::label('Nombre Producto') }}
            {{ Form::text('nombreProducto', $producto->nombreProducto, ['class' => 'form-control' . ($errors->has('nombreProducto') ? ' is-invalid' : ''),
                'required',
                'minlength' => '3',
                'maxlength' => '30',
            ]) }}
            {!! $errors->first('nombreProducto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Talla') }}
            {{ Form::select('Talla', ['0-3 meses' => '0-3 meses', '3-6 meses' => '3-6 meses', '6-9 meses' => '6-9 meses'], $producto->Talla, ['class' => 'form-control' . ($errors->has('Talla') ? ' is-invalid' : ''), 
              'required',
              'placeholder' => 'Selecciona una talla'
            ]) }}
            {!! $errors->first('Talla', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group" onkeypress="return validarNumero(event)">
            {{ Form::label('Cantidad') }}
            {{ Form::number('Cantidad', $producto->Cantidad, ['class' => 'form-control' . ($errors->has('Cantidad') ? ' is-invalid' : ''),
              'required',
              'min' => '0',
              'max' => '999999999',
            ]) }}
            {!! $errors->first('Cantidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Categoría') }}
            {{ Form::select('Categoria', ['Camisa' => 'Camisa', 'Pantalón' => 'Pantalón', 'Conjunto' => 'Conjunto', 'Pijamas' => 'Pijamas'], $producto->Categoria, ['class' => 'form-control' . ($errors->has('Categoria') ? ' is-invalid' : ''), 
              'required',
              'placeholder' => 'Selecciona una categoría',
            ]) }}
            {!! $errors->first('Categoria', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group" onkeypress="return validarNumero(event)">
            {{ Form::label('Precio') }}
            {{ Form::number('Precio', $producto->Precio, ['class' => 'form-control' . ($errors->has('Precio') ? ' is-invalid' : ''),
                'required',
                'min' => '0',
                'max' => '999999999',
            ]) }}
            {!! $errors->first('Precio', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Foto del Producto') }}
            <br>
              <label for="foto-input">
                <img id="preview-image" src="{!! $producto->Foto ? asset("images/products/$producto->Foto") : asset("images/placeholders/product-placeholder.png") !!}">
              </label>
            {{ Form::file('Foto', ['class' => 'form-control' . ($errors->has('Foto') ? ' is-invalid' : ''), 'id' => 'foto-input',
              'accept' => 'image/jpeg, image/png, image/jpg, image/gif'
            ]) }}
            {!! $errors->first('Foto', '<div class="invalid-feedback">:message</div>') !!}
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

    function validarEntrada(event) {
      const key = event.key;
      const regex = /^[a-zA-Z0-9 ]$/;
      if (!regex.test(key)) {
        event.preventDefault();
      }
    }

    // Previsualización de la foto
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('foto-input').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(event) {
                var previewImage = document.getElementById('preview-image');
                previewImage.src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    });

    document.getElementById('form')?.addEventListener('submit', function(event) {
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