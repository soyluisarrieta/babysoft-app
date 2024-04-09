<div class="container">
    <!-- Lista de productos disponibles -->
    <div class="row">
        <div class="col-md">
            <div class="form-group">
                {{ Form::label('Fecha') }}
                {{ Form::date('Fecha', $fechaActual, [
                    'class' => 'form-control' . ($errors->has('Fecha') ? ' is-invalid' : ''), 
                    'placeholder' => 'Fecha',
                    'min' => now()->subDays(20)->format('Y-m-d'), // Restringe la fecha mínima 20 días en el pasado
                    'max' => now()->format('Y-m-d') // Restringe la fecha máxima a la fecha actual
                ]) }}
                {!! $errors->first('Fecha', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            
            {{ Form::label('Productos') }}
            <select id="idReferencia" name="idReferencia" class="form-control mb-3 {{ isset($errors) && $errors->has('idReferencia') ? ' is-invalid' : '' }}">
                <option value="">Selecciona una producto</option>
                @foreach ($productos as $prod)
                    <option value="{{ $prod->idReferencia }}" data-precio="{{ $prod->Precio }}" {{ old('idReferencia') == $prod->idReferencia ? 'selected' : '' }}>
                        {{ $prod->nombreProducto }}
                    </option>
                @endforeach
            </select>
            @if (isset($errors) && $errors->has('idReferencia'))
                <div class="invalid-feedback d-block">{{ $errors->first('idReferencia') }}</div>
            @endif

            <div class="form-group mb-3" onkeypress="return validarNumero(event)">
              {{ Form::label('Valor unitario') }}
              <div class="row">
                <div class="col pe-1">
                {{ Form::number('precioUnitario', $detalleVenta->precioUnitario, ['id' => 'precioUnitario', 'placeholder'=> '0', 'min'=> '0','class' => 'form-control' . ($errors->has('precioUnitario') ? ' is-invalid' : ''), 'disabled']) }}
                </div>
                <button id="editarPrecio" type="button" class="btn btn-warning col-auto">
                  <i id="iconoEditar" class="far fa-edit"></i>
                </button>
              </div>
              {!! $errors->first('precioUnitario', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <br>
        </div>
        
        <div class="col-md">
          <!-- Seleccionar Cliente -->
          <div class="mb-3" onkeypress="return validarNumero(event)" required>
              {{ Form::label('Clientes') }}
              {{ Form::select('idCliente', $clientes, $venta->idCliente, ['id' => 'idCliente', 'class' => 'form-control' . ($errors->has('idCliente') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un cliente']) }}
              {!! $errors->first('idCliente', '<div class="invalid-feedback">:message</div>') !!}
          </div>

          <div class="form-group mb-3" onkeypress="return validarNumero(event)" required>
              {{ Form::label('Cantidad') }}
              {{ Form::number('Cantidad', $detalleVenta->Cantidad ?? 1, ['id' => 'CantidadVenta', 'min'=> '1','class' => 'form-control' . ($errors->has('Cantidad') ? ' is-invalid' : ''),
                'min' => '0',
                'max' => '9999999999',
              ]) }}
              {!! $errors->first('Cantidad', '<div class="invalid-feedback">:message</div>') !!}
          </div>

          <div class="form-group mb-3" onkeypress="return validarNumero(event)" required>
              {{ Form::hidden('Subtotal', $detalleVenta->Subtotal ?? 0, ['id' => 'Subtotal', 'readonly' => 'true', 'class' => 'form-control' . ($errors->has('Subtotal') ? ' is-invalid' : ''),
                'min' => '0',
                'max' => '9999999999',
              ]) }}
              {!! $errors->first('Subtotal', '<div class="invalid-feedback">:message</div>') !!}
          </div>
        </div>

        <div class="col-md-auto d-flex flex-column">
          <button class="btn btn-outline-secondary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#nuevoProducto">
            <i class="fas fa-box-open fa-2x d-block"></i>
            Crear nuevo producto
          </button>
          <button id="agregarDetalle" class="btn btn-primary" type="button">
            <i class="far fa-arrow-alt-circle-down fa-2x d-block"></i>
            Añadir a la lista
          </button>
        </div>
    </div>

    <div>
        <!-- Productos seleccionados -->
          <table class="table table-striped" id="tablaProductos">
              <thead>
                  <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Subtotal</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <!-- Aquí se agregarán las filas de los productos seleccionados -->
              </tbody>
          </table>
    
          @if (isset($errors) && $errors->has('detallesVenta'))
            <div class="alert alert-danger">{{ $errors->first('detallesVenta') }}</div>
          @endif

          <div class="form-group" onkeypress="return validarNumero(event)" required>
              {{ Form::label('ValorTotal') }}
              {{ Form::text('ValorTotal', $venta->ValorTotal ?? 0, ['id' => 'ValorTotal', 'readonly' => 'true', 'class' => 'form-control' . ($errors->has('ValorTotal') ? ' is-invalid' : '')]) }}
              {!! $errors->first('ValorTotal', '<div class="invalid-feedback">:message</div>') !!}
          </div>

          <!-- Lista de productos agregados -->
          {{ Form::hidden('detallesVenta', $venta->detallesVenta, ['id' => 'detallesVentaInput', 'class' => 'form-control']) }}
          <br>
    </div>
    
    <br>
    {{-- <a href="#" class="btn btn-primary" id="agregarDetalle">Agregar Producto</a> --}}
    <form id="ventaForm"> <!-- Formulario para manejar el evento submit -->
        <button type="submit" class="btn btn-success guardarVenta">Finalizar</button>
    </form>
</div>

<!-- Modal nuevo producto -->
<div class="modal fade" id="nuevoProducto" tabindex="-1" aria-labelledby="nuevoProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevoProductoLabel">Crear nuevo producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  
        <div class="modal-body">
          @if (session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
          @endif

            <form id="formNuevoProducto" role="form" enctype="multipart/form-data">
                @csrf

                @include('producto.form')

                
                <div class="float-right">
                  <button id="cancel-nuevoProducto" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
                <div class="box-footer mt20">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>ㅤ{{ __('Crear') }}</button>
                </div>
            </form>
        </section>
       </div> 
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Evento para reiniciar el modal y formulario
      $('#cancel-nuevoProducto').click(function() {
        setTimeout(() => {
          $('#formNuevoProducto')[0].reset();
          $('#preview-image').attr('src', "{{ asset('images/placeholders/product-placeholder.png') }}");
        }, 500);
      });

    // Agregar nuevo producto sin actualizar la página
      $('#formNuevoProducto').on('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);
          
          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: "{{ url('/') }}" + "/nuevo-producto",
              data: formData,
              processData: false,  // Indica a jQuery que no procese los datos
              contentType: false,  // Indica a jQuery que no establezca el tipo de contenido
              success: function(data){
                  // Mostrar alerta
                  Swal.fire({
                      position: "top-end",
                      title: "¡Listo!",
                      icon: "success",
                      showConfirmButton: false,
                      timer: 1500
                  });

                  // Actualizar el select
                  var select = $('#idReferencia');
                  select.empty();
                  select.append($('<option></option>').attr('value', '').text('Selecciona una producto'));
                  $.each(data.productos, function(key, producto) {
                      select.append(
                          $('<option></option>')
                            .attr('value', producto.idReferencia)
                            .attr('data-precio', producto.Precio) 
                            .text(producto.nombreProducto)
                      );
                  });
                  
                  // Reiniciar modal
                  $('#cancel-nuevoProducto').click();
              },
              error: function(jqXHR, textStatus, errorThrown){
                  let errorMessage =  jqXHR.responseJSON?.error
                  ? jqXHR.responseJSON.error
                  : "Hubo un problema al enviar el formulario."

                  Swal.fire({
                      title: "¡Error!",
                      text: errorMessage,
                      icon: "error",
                  });
              }
          });
      });
  });
</script>

<script>
    let detallesVenta = []; // Array para almacenar los detalles de venta

    $('#agregarDetalle').on('click', function(e) {
        e.preventDefault();


        let idCliente = $('#idCliente').val();
        let idReferencia = $('#idReferencia').val();
        let nombreProducto = $('#idReferencia :selected').text();
        let Cantidad = $('#CantidadVenta').val();
        let precioUnitario = parseFloat($('#idReferencia :selected').data('precio')); // Obtener el precio del producto
        let Subtotal = precioUnitario * Cantidad; // Calcular el subtotal

        if (!$('#idReferencia').val()) {
            return $('#idReferencia').focus();
        }
        
        if (!$('#idCliente').val()) {
            return $('#idCliente').focus();
        }

        if (!$('#CantidadVenta').val()) {
            return $('#CantidadVenta').focus();
        }

        detallesVenta.push({ // Agregar el detalle al array
            idCliente: idCliente,
            idReferencia: idReferencia,
            nombreProducto: nombreProducto,
            precioUnitario: precioUnitario,
            Cantidad: Cantidad,
            Subtotal: Subtotal
        });
        
        let nuevaFila = `
            <tr>
                <td>${nombreProducto}</td>
                <td>${Cantidad}</td>
                <td>${Subtotal.toFixed(0)}</td>
                <td><button class="btn eliminarProducto">X</button></td>
            </tr>
        `;

        $('#tablaProductos tbody').append(nuevaFila);

        let detalleHTML = `
            <div class="detalle">
                <p>ㅤ${nombreProducto} ㅤ-ㅤ ${Cantidad} ㅤ-ㅤ ${Subtotal.toFixed(0)} <span class="eliminarProducto">X</span></p>
            </div>
        `;

        $('.productos-seleccionados').append(detalleHTML); // Mostrar el detalle en la interfaz

        let detalleVentaHTML = '<ul>'; // O cualquier otro formato que prefieras
        detallesVenta.forEach(detalle => {
            detalleVentaHTML +=
                `<li>idReferencia: ${detalle.idReferencia}, Cantidad: ${detalle.Cantidad}, Subtotal: ${detalle.Subtotal}</li>`;
        });
        detalleVentaHTML += '</ul>';

        $('#detalleVentaInfo').html(detalleVentaHTML);
        $('#detallesVentaInput').val(JSON.stringify(detallesVenta));

         // Reiniciar los campos específicos en lugar de todo el formulario
        $('#idReferencia').val('');
        $('#CantidadVenta').val(1);
        $('#precioUnitario').val('');
        $('#Subtotal').val(0);
        $('#precioProductoLabel').text('$0');
    });

    $('#tablaProductos').on('click', '.eliminarProducto', function() {
        // Encuentra el índice del detalle en el array detallesVenta
        let index = $(this).closest('tr').index();
        // Elimina el detalle del array
        detallesVenta.splice(index,  1);
        // Actualiza el input oculto con los detalles actualizados
        $('#detallesVentaInput').val(JSON.stringify(detallesVenta));
        // Elimina la fila de la tabla
        $(this).closest('tr').remove();
        // Recalcula y actualiza el valor total
        calcularValorTotal();
    });


    // Función para calcular el valor total
    function calcularValorTotal() {
    let valorTotal = 0;

    // Recorre los detalles y suma los subtotales
    detallesVenta.forEach(detalle => {
        valorTotal += detalle.Subtotal;
    });

    // Sumar el valor del Subtotal actual
    let Subtotal = parseFloat($('#Subtotal').val());
    valorTotal += Subtotal;

    // Actualizar el campo ValorTotal
    $('#ValorTotal').val(valorTotal.toFixed(0)); // Asegúrate de que el valor esté formateado correctamente
}


    $('#ventaForm').on('submit', function(e) {
        e.preventDefault();

        console.log("Detalles de Venta:", detallesVenta);

        if (detallesVenta.length > 0) {
            // El array detallesVenta tiene datos
            console.log("detallesVenta tiene datos");

            // Obtener la URL de la ruta definida en Laravel para VentaController@store
            let url = '{{ route('ventas.store') }}'; // Reemplaza 'ventas.store' con el nombre de tu ruta

            // Realizar la solicitud AJAX
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    detalles: detallesVenta // Enviar el array directamente
                },
                success: function(response) {
                    // Manejar la respuesta del servidor si es necesaria
                    console.log(response);
                },
                error: function(error) {
                    // Manejar el error si ocurre alguno
                    console.error(error);
                }
            });
        } else {
            // El array detallesVenta está vacío
            console.log("No hay datos en detallesVenta para enviar al servidor");
        }
    });




    // Agrega este código dentro del evento 'change' para actualizar el subtotal y el total cada vez que cambie la cantidad o el producto seleccionado
    $('#idReferencia, #CantidadVenta').on('input', function() {
        let idReferencia = $('#idReferencia').val();
        let Cantidad = $('#CantidadVenta').val();

        // Comprobar si se ha seleccionado un producto y se ha especificado una cantidad
        if (idReferencia !== "" && Cantidad !== "") {
            let precioUnitario = parseFloat($('#idReferencia :selected').data('precio')); // Obtener el precio del producto
            let Subtotal = precioUnitario * Cantidad; // Calcular el subtotal

            // Actualizar el campo Subtotal
            $('#Subtotal').val(Subtotal.toFixed(0));

            // Calcular el valor total y actualizarlo
            calcularValorTotal();
        } else {
          Swal.fire({
            title: "Error!",
            text: "Por favor, selecciona un producto y especifica la cantidad.",
            icon: "error",
            button: "OK",
        });
        }
    });

    $(document).ready(function(){
      const detallesVentaInputValue = $('#detallesVentaInput').val();
      if (detallesVentaInputValue) {
          detallesVenta = JSON.parse(detallesVentaInputValue);
      }

      let detalleHTML = '';
      const detalles = JSON.parse($('#detallesVentaInput').val() || null)
      detalles && detalles.forEach(detalle => {
        detalleHTML += `
            <tr>
              <td>${detalle.nombreProducto}</td>
              <td>${detalle.Cantidad}</td>
              <td>${detalle.Subtotal.toFixed(0)}</td>
              <td><button class="btn eliminarProducto">X</button></td>
            </tr>
        `;
      });

      $('#tablaProductos tbody').append(detalleHTML);
    })

    $('#idReferencia').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var price = selectedOption.data('precio');
        $('#precioProductoLabel').text('$' + price.toFixed(0));
    });

    // Precio unitario
    $(document).ready(function(){
      $('#idReferencia').change(function(){
            var precio = $('option:selected', this).attr('data-precio');
            $('#precioUnitario').val(precio);
        });

        $('#precioUnitario').on('input', function() {
            let precioUnitario = $(this).val();
            $('#idReferencia :selected').data('precio', precioUnitario);            
            $('#idReferencia :selected').attr('data-precio', precioUnitario);

            // Cuando se cambia el precio unitario, recalcula el subtotal y el valor total
            let Cantidad = $('#CantidadVenta').val();
            let Subtotal = precioUnitario * Cantidad;

            $('#Subtotal').val(Subtotal.toFixed(0));

            calcularValorTotal();
        });

        // Cuando se presiona el botón, habilita o deshabilita el input de precio unitario y cambia el ícono
        $('#editarPrecio').click(function(){
            let precioUnitarioInput = $('#precioUnitario');
            let iconoEditar = $('#iconoEditar');
            if (precioUnitarioInput.prop('disabled')) {
                precioUnitarioInput.prop('disabled', false);
                iconoEditar.removeClass('far fa-edit').addClass('fas fa-undo');
                // Guarda el precio actual como un atributo de datos en el input
                precioUnitarioInput.data('original', precioUnitarioInput.val());
            } else {
                precioUnitarioInput.prop('disabled', true);
                iconoEditar.removeClass('fas fa-undo').addClass('far fa-edit');
                // Reinicia el precio al valor original
                let precioOriginal = precioUnitarioInput.data('original');
                precioUnitarioInput.val(precioOriginal);
                $('#idReferencia :selected').data('precio', precioOriginal);

                // Recalcular el subtotal y el total
                let Cantidad = $('#CantidadVenta').val();
                let Subtotal = precioOriginal * Cantidad;
                $('#Subtotal').val(Subtotal.toFixed(0));
                calcularValorTotal();
            }
        });

        // Cuando se agrega un detalle, deshabilita el input de precio unitario y cambia el ícono a editar
        $('#agregarDetalle').click(function(){
            $('#precioUnitario').prop('disabled', true);
            $('#iconoEditar').removeClass('fas fa-undo').addClass('far fa-edit');
        });
    });
    
</script>















<style>
    /* Agregar estilos para el botón de eliminar (X) */
    .eliminarProducto {
        color: red;
        /* Cambia el color de la X a rojo */
        cursor: pointer;
        margin-left: 5px;
        float: right;
        /* Colocar el botón al final de la línea */
    }
</style>




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
</script>
