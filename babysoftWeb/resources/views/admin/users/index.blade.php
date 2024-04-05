@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="text-center" style="font-size: 33px; font-weight: bold;">
                            {{ __('Usuarios') }}
                        </span>

                             <div class="float-right">
                                <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>{{ __('Agregar Usuario') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usuarioss" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>ID</th>
										<th>Nombre Completo</th>
										<th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            @foreach($user->roles as $role)
                                                <td>{{ $role->name }}</td>
                                            @endforeach

                                            
                                            <td>
                                              <div class="form-group">
                                                  <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input active-toggle" id="isActived{{ $user->id }}" data-id="{{ $user->id }}" {{ $user->isActived ? 'checked' : '' }} {{ Auth::id() == $user->id ? 'disabled' : '' }}>
                                                    <label role="button" class="custom-control-label" for="isActived{{ $user->id }}"></label>
                                                  </div>
                                              </div>
                                            </td>

                                            <td>
                                                <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.formulario-eliminar').submit(function(e){
            e.preventDefault();
  
        Swal.fire({
        title: '¿Quieres eliminar este usuario?',
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

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $('#usuarioss').DataTable({
            responsive: true,
            autoWidth: true,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del  0 al  0 de un total de  0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        // Actualizar el estado del usuario sin reiniciar la página
        $(document).ready(function(){
          $('.active-toggle').change(function() {
              const originalState = !$(this).prop('checked');
              const isActived = $(this).prop('checked') === true ? 1 : 0;
              const userId = $(this).data('id');
              const url = "{{ url('/') }}" + "/usuarios/" + userId + "/toggle-active";

              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: url,
                  data: {'isActived': isActived, "_token": "{{ csrf_token() }}"},
                  success: function(data){
                      Swal.fire({
                          position: "top-end",
                          title: "¡Listo!",
                          icon: "success",
                          showConfirmButton: false,
                          timer: 1500
                      });
                  },
                  error: function(jqXHR, textStatus, errorThrown){
                    let errorMessage =  jqXHR.responseJSON?.error
                      ? jqXHR.responseJSON.error
                      : "Hubo un problema al actualizar el estado del usuario."

                    Swal.fire({
                        title: "¡Error!",
                        text: errorMessage,
                        icon: "error",
                    });
                    // Revertir el switch a su estado original
                    $(this).prop('checked', originalState);
                  }.bind(this)
              });
          })
      })
    </script>
@stop


