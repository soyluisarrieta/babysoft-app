<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetalleCompra
 *
 * @property $idDetalleCompras
 * @property $idCompra
 * @property $idReferencia
 * @property $Cantidad
 * @property $Subtotal
 * @property $created_at
 * @property $updated_at
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DetalleCompra extends Model
{
    protected $primaryKey = 'idDetalleCompras';
    
    static $rules = [
        'idCompra' => 'required',
        'idReferencia' => 'required',
        'Cantidad' => 'required',
        'Subtotal' => 'required',
    ];

    protected $fillable = ['idCompra', 'idReferencia', 'Cantidad', 'Subtotal'];

    public function producto() {
        return $this->belongsTo(Producto::class, 'idReferencia', 'idReferencia');
    }
}

