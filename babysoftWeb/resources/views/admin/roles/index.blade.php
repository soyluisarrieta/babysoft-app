@extends('adminlte::page')

@section('template_title')
    {{ __('Lista De Roles') }} Cliente
@endsection

@section('css')
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
                            {{ __('Roles') }}
                        </span>
                            <div class="float-right">
                                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>{{ __('Agregar Rol') }}
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
                            <table id="rol" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th width="10">Identificador</th>
										<th>Nombre Del Rol</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td width="10">
                                                <button class="btn btn-secondary ver-permisos" data-bs-toggle="modal" data-bs-target="#ver-permisos" title="Ver permisos" data-rolname="{{ $role->name }}" data-permissions="{{ $role->permissions }}"><i class="fa fa-fw fa-eye"></i></button>
                                            </td>
                                            <td width="10">
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
                                            </td>
                                            <td width="10">
                                                <form action="{{ route('roles.destroy', $role->id) }}" class="formulario-eliminar" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger " onclick="confirmarEliminacion(event)"><i class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="ver-permisos" tabindex="-1" aria-labelledby="ver-permisosLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ver-permisosLabel">Permisos del rol</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex justify-content-between mb-2">
              <h3 id="role-name-header">Nombre del rol</h3>
              <a href="{{ route('roles.edit', $role->id) }}" class="link-primary"><i class="fa fa-fw fa-edit"></i></a>
            </div>
            <div class="row">
              <h3 class="h5">Lista de Permisos</h3>
              @foreach ($permisos as $permiso)
                  <div class="col-md-6">
                      {!! Form::checkbox('permisos[]', $permiso->id, $role->permissions->contains($permiso->id), ['class' => '', 'readonly']) !!}
                      {{ $permiso->name }}
                  </div>
              @endforeach
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
        title: '¿Quieres ELIMINAR este rol?',
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
        $('#rol').DataTable({
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
        $(document).ready(function() {
          // Modo lectura en el modal de los permisos
          $('#ver-permisos input[type="checkbox"]').on('click', function(e) {
              e.preventDefault();
          });

          // Actualizar modal dependiendo del rol
          $('.ver-permisos').click(function() {
            const roleName = $(this).data('rolname')
            const permissions = $(this).data('permissions')
            $('#role-name-header').text('Rol: ' + roleName);
            
            // Primero, desmarca todos los checkboxes
            $('input[type="checkbox"]').prop('checked', false);

            // Luego, marca solo los permisos correspondientes a este rol
            permissions.forEach(permission => {
                $('input[type="checkbox"][value="' + permission.id + '"]').prop('checked', true);
            });
          });
      });
    </script>

@stop