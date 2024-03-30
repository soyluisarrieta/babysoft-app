<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleVenta
 *
 * @property $idDetalleVentas
 * @property $idVenta
 * @property $idReferencia
 * @property $Cantidad
 * @property $Subtotal
 * @property $created_at
 * @property $updated_at
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DetalleVenta extends Model
{
    protected $primaryKey = 'idDetalleVentas';
    
    static $rules = [
        'idVenta' => 'required',
        'idReferencia' => 'required',
        'Cantidad' => 'required',
        'Subtotal' => 'required',
    ];

    protected $fillable = ['idVenta', 'idReferencia', 'Cantidad', 'Subtotal'];

        // En el modelo DetalleVenta
    public function producto() {
        return $this->belongsTo(Producto::class, 'idReferencia', 'idReferencia');
    }

}
