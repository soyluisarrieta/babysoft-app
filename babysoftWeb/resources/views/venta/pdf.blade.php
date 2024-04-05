<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Ventas</title>
    <style>
        /* Estilos CSS adicionales para el formato del PDF */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: dodgerblue;
        }
        h1 {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }
        .image-container {
            display: flex;
            justify-content: center;
            text-align: center;
        }
        .image-container img {
            text-align: center;
            width: 150px;
            height: 70px;
        }
        .header {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            text-align: center;
        }
        .page-number:before {
            content: "Página " counter(page);
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="C:\xampp\htdocs\proyecto1\public\LogoSinFondo.png" alt="">
    </div>
    <br>
    <br>
    <h1>Reporte de Ventas</h1><br>
    <div class="header">
        <p>Fecha de generación del reporte: {{ date('Y-m-d') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>IdVenta</th>
                <th>Nombre Cliente</th>
                <th>Articulo</th>
                <th>Cantidad</th>
                <th>Valor Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->idVenta }}</td>
                    <td>{{ $clientes[$venta->idCliente] }}</td>
                    <td>{{ $productos[$venta->idReferencia] }}</td>
                    <td>{{ $venta->Cantidad }}</td>
                    <td>{{ $venta->ValorTotal }}</td>
                    <td>{{ $venta->Fecha }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p class="page-number"></p>
    </div>
</body>
</html>
