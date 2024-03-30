<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    protected $primaryKey = 'idProveedor';

    /**
     * Reglas de validación
     */
    public static function rules($id = null)
    {
        return [
            'Cedula' => 'required|string|min:5|max:15|unique:proveedores,Cedula,' . $id . ',idProveedor',
            'NombreProveedor' => 'required|string|min:3|max:30',
            'Correo' => 'required|email|unique:proveedores,Correo,' . $id . ',idProveedor',
            'Telefono' => 'required|string|size:10',
            'Fecha' => 'required',
        ];
    }

    /**
     * Atributos que pueden ser asignados masivamente.
     */
    protected $fillable = ['Cedula', 'NombreProveedor', 'Correo', 'Telefono', 'Fecha'];

    /**
     * Obtener los proveedores que tienen la misma cédula.
     */
    public function scopeSameCedula($query, $cedula)
    {
        return $query->where('Cedula', $cedula);
    }

    /**
     * Obtener los proveedores que tienen el mismo correo.
     */
    public function scopeSameCorreo($query, $correo)
    {
        return $query->where('Correo', $correo);
    }

    public function compras()
    {
        return $this->hasMany(compra::class, 'idProveedor', 'idProveedor');
    }
}
