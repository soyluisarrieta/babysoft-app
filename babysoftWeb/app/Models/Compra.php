<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Compra
 *
 * @property $idCompra
 * @property $idProveedor
 * @property $ValorTotal
 * @property $Fecha
 * @property $Anulado
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Compra extends Model
{
  protected $primaryKey = 'idCompra';
    
    static $rules = [
		'idProveedor' => 'required',
		'ValorTotal' => 'required',
		'Fecha' => 'required',
    'Anulado' => 'boolean',
    ];

    protected $perPage = 1000;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idCompra','idProveedor','ValorTotal','Fecha', 'Anulado'];

    public function detalles_compra()
    {
        return $this->hasMany(DetalleCompra::class, 'idCompra');
    }
}
