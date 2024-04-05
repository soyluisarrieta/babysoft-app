<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $idReferencia
 * @property $nombreProducto
 * @property $Talla
 * @property $Cantidad
 * @property $Categoria
 * @property $Precio
 * @property $Foto
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
  protected $primaryKey = 'id';
    static $rules = [
    'idReferencia' => 'required',
		'nombreProducto' => 'required',
		'Talla' => 'required',
		'Cantidad' => 'required',
		'Categoria' => 'required',
    'Precio' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','idReferencia','nombreProducto','Talla','Cantidad','Categoria','Precio','Foto'];

    public function ventas()
    {
      return $this->hasMany(DetalleVenta::class, 'idReferencia', 'idReferencia');
    }

    public function compras()
    {
      return $this->hasMany(DetalleCompra::class, 'idReferencia', 'idReferencia');
    }


}
