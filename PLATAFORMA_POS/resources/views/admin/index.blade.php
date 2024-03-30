@extends('adminlte::page')


@section('content_header')
    <h1></h1>
@stop

@section('content')
    <style>
        .charts {
            margin-top: 30px;
            background: white;
            box-shadow: 0 5px 12px rgb(0 0 0 / 4%);
        }

        .charts div {
            border-radius: 7px;
            padding: 40px;
            padding-top: 0;
        }
    </style>

    <!-- <button id="btnEliminar">Eliminar</button> -->

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('backup.create') }}" class="formulario-backup" method="GET">
        <button type="submit" class="btn btn-primary"><i class="fa fa-cloud" aria-hidden="true"></i>Generar Backup</button>
    </form>

    <div class="row">
        <div class="col-lg-4 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $comprasRealizadas }}</h3>
                    <p>Compras realizadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="{{ url('/compras') }}" class="small-box-footer">Más información <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $ventasRealizadas }}</h3>
                    <p>Ventas realizadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <a href="{{ url('/ventas') }}" class="small-box-footer">Más información <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $productosEnStock }}</h3>
                    <p>Productos en Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <a href="{{ url('/productos') }}" class="small-box-footer">Más información <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
            <canvas id="grafico-compra-y-ventas" height="350"></canvas>
        </div>
    </div>

    {{-- <div class="charts">
        <br>
        <br>
        <h2 align="center">Ventas totales</h2>
        <div>
            <canvas id="grafico-ventas" height="300px"></canvas>
        </div>

        <h2 align="center">Stock de productos</h2>
        <div>
            <canvas id="grafico-productos" height="500px"></canvas>
        </div>
    </div> --}}

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.formulario-backup').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Quieres hacer un Backup?',
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

    <!-- ChartJS -->
    <script src="{{ asset('vendor/chartjs/chart.min.js') }}"></script>

    {{-- Gráfico de compras y ventas realizadas --}}
    <script>
      const compras = @json($compras);
      const ventas = @json($ventas);

      // Función para obtener el día de la semana en formato de texto
      function obtenerDiaSemanaTexto(fecha) {
          const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
          return diasSemana[new Date(fecha).getDay()];
      }

      // Función para convertir fecha y ajustar la zona horaria
      function convertirFecha(fecha) {
          const fechaLocal = new Date(fecha);
          return new Date(fechaLocal.getTime() + fechaLocal.getTimezoneOffset() * 60000);
      }

      // Obtener la fecha más reciente de ventas o compras
      const fechasVentasCompras = [...ventas, ...compras].map(ventaCompra => convertirFecha(ventaCompra.Fecha));
      const fechaMasReciente = new Date(Math.max(...fechasVentasCompras));

      // Obtener los últimos 7 días, incluyendo el día más reciente
      const ultimos7Dias = Array.from({ length: 7 }, (_, i) => {
          const fechaDia = new Date(fechaMasReciente);
          fechaDia.setDate(fechaDia.getDate() - i);
          return fechaDia;
      }).reverse();

      // Función para obtener datos de ventas o compras por día de la semana
      function obtenerDatosPorDiaSemana(ventasCompras, tipo) {
          const datosPorDiaSemana = Array(7).fill(0);
          ventasCompras.forEach(ventaCompra => {
              const diaSemana = ultimos7Dias.findIndex(fecha => obtenerDiaSemanaTexto(fecha) === obtenerDiaSemanaTexto(convertirFecha(ventaCompra.Fecha)));
              if (diaSemana !== -1) {
                  datosPorDiaSemana[diaSemana]++;
              }
          });
          return {
              label: tipo,
              backgroundColor: tipo === 'Ventas' ? 'rgba(60,141,188,0.9)' : 'rgba(210, 214, 222, 1)',
              borderColor: tipo === 'Ventas' ? 'rgba(60,141,188,0.8)' : 'rgba(210, 214, 222, 1)',
              pointColor: tipo === 'Ventas' ? '#3b8bba' : 'rgba(210, 214, 222, 1)',
              pointStrokeColor: tipo === 'Ventas' ? 'rgba(60,141,188,1)' : '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: tipo === 'Ventas' ? 'rgba(60,141,188,1)' : 'rgba(220,220,220,1)',
              data: datosPorDiaSemana
          };
      }

      // Configurar los datos para el gráfico
      const chartData = {
          labels: ultimos7Dias.map((fecha, index) => `${obtenerDiaSemanaTexto(fecha)}\n${fecha.toISOString().split('T')[0]}`),
          datasets: [
              obtenerDatosPorDiaSemana(ventas, 'Ventas'),
              obtenerDatosPorDiaSemana(compras, 'Compras')
          ]
      };

      // Configurar opciones del gráfico
      const chartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          scales: {
              xAxes: [{
                  ticks: {
                      autoSkip: false, // Evitar que los días se corten
                      maxRotation: 0, // Rotar la etiqueta del día
                      callback: function(value, index, values) {
                          // Dividir el texto en varias líneas
                          return value.split('\n');
                      }
                  }
              }]
          }
      };

      // Obtener el contexto del canvas
      const salesChartCanvas = document.getElementById('grafico-compra-y-ventas').getContext('2d');

      // Inicializar el gráfico
      const salesChart = new Chart(salesChartCanvas, {
          type: 'line',
          data: chartData,
          options: chartOptions
      });
    </script>
  
  
  
  
    {{-- Anteriores gráficos --}}
    <script>
        /*
            const ctx1 = document.getElementById('grafico-ventas');
            new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: @json($nombresProd1),
                    datasets: [{
                        data: @json($totalesVenta)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (value) => `Total: $${value.formattedValue}`
                            }
                        }
                    }
                }
            });

            const ctx2 = document.getElementById('grafico-productos');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: @json($nombresProd2),
                    datasets: [{
                        label: 'Cantidad',
                        data: @json($cantidadesProd),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                    }
                }
            });
            */
    </script>
@stop
