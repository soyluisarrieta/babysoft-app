<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Cliente extends Model
{
    protected $primaryKey = 'idCliente';

    protected $fillable = ['numeroIdentificacion', 'Nombre', 'Apellido', 'Email', 'Telefono'];

    public static function validationRules($id = null)
    {
        return [
            'numeroIdentificacion' => 'required|string|size:10',
            'Nombre' => 'required|string|min:3|max:30',
            'Apellido' => 'required|string|min:3|max:30',
            'Email' => [ 'required', 'email', 'min:5', 'max:30',
                Rule::unique('clientes', 'Email')->ignore($id, 'idCliente'),
            ],
            'Telefono' => 'required|string|size:10',
        ];
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idCliente', 'idCliente');
    }
}
