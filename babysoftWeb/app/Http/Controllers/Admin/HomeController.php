<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    // Compras
    $compras = Compra::all();
    $comprasRealizadas = $compras->count();
    
    // Ventas
    $ventas = Venta::all();
    $ventasRealizadas = $ventas->count();

    $productosConTotalVenta = Producto::select(
        'productos.nombreProducto',
        DB::raw('IFNULL(SUM(ventas.ValorTotal), 0) as totalVenta')
    )
        ->leftJoin('detalle_ventas', 'productos.idReferencia', '=', 'detalle_ventas.idReferencia')
        ->leftJoin('ventas', 'detalle_ventas.idVenta', '=', 'ventas.idVenta')
        ->groupBy('productos.nombreProducto')
        ->orderBy('totalVenta', 'asc') // Ordenar por total de ventas en orden descendente
        ->take(10) // Limitar a los 10 productos más vendidos
        ->get();

    $nombresProd = $productosConTotalVenta->pluck('nombreProducto')->toArray();
    $totalesVenta = $productosConTotalVenta->pluck('totalVenta')->toArray();

    // Productos
    $productos = Producto::all();
    $productosEnStock = $productos->sum('Cantidad');

    return view('admin.index', compact(
      'nombresProd', 
      'totalesVenta', 
      'ventas',
      'ventasRealizadas', 
      'compras',
      'comprasRealizadas', 
      'productosEnStock'
    ));
  }
}
