<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $primaryKey = 'id_medico';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'especialidad',
        'numero_colegiatura',
        'telefono',
        'activo',
    ];
}
