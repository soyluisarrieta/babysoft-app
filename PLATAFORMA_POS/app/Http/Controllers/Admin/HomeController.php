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
      ->get();

    $nombresProd1 = $productosConTotalVenta->pluck('nombreProducto')->toArray();
    $totalesVenta = $productosConTotalVenta->pluck('totalVenta')->toArray();

    // Productos
    $productos = Producto::all();
    $nombresProd2 = $productos->pluck('nombreProducto')->toArray();
    $cantidadesProd = $productos->pluck('Cantidad')->toArray();
    $productosEnStock = $productos->sum('Cantidad');

    return view('admin.index', compact(
      'nombresProd1', 
      'totalesVenta', 
      'ventas',
      'ventasRealizadas', 
      'compras',
      'comprasRealizadas', 
      'nombresProd2', 
      'cantidadesProd', 
      'productosEnStock'
    ));
  }
}
