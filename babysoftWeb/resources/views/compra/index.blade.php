@extends('adminlte::page')

@section('css')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('template_title')
    Compra
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title" class="text-center" style="font-size: 33px; font-weight: bold;">
                            {{ __('Compras') }}
                        </span>

                             <div class="float-right">
                                <a href="{{ route('compras.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>{{ __('Agregar Compra') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="comp" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        
                                        <th>ID</th>
										<th>Valor Total</th>
										<th>Fecha</th>  

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compras as $compra)
                                        <tr>
                                            
                                            <td>{{ $compra->idCompra }}</td>
											<td>${{ number_format($compra->ValorTotal, 0, ',', '.') }}</td>
											<td>{{ $compra  ->Fecha }}</td>

                                            <td>
                                                <form id="form" class="formulario-eliminar" action="{{ route('compras.destroy',$compra->idCompra) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('compras.show',$compra->idCompra) }}"><i class="fa fa-fw fa-eye"></i> {{ __('') }}</a>
                                                    <!-- <a class="btn btn-sm btn-success" href="{{ route('compras.edit',$compra->idCompra) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a> -->
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="confirmarEliminacion(event)"><i class="fa fa-fw fa-trash"></i> {{ __('Anular') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $compras->links() !!} --}}
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
        title: '¿Quieres ELIMINAR esta compra?',
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
        $('#comp').DataTable({
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
    </script>
@stop