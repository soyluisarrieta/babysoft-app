<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 *
 * @property $idVenta
 * @property $idCliente
 * @property $ValorTotal
 * @property $Fecha
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Venta extends Model
{
  protected $primaryKey = 'idVenta';
    static $rules = [
		'idCliente' => 'required',
		'ValorTotal' => 'required',
		'Fecha' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idVenta','idCliente','ValorTotal','Fecha'];



}
