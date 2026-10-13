<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $primaryKey = 'id_cita';

    public $timestamps = false;

    protected $fillable = [
        'id_paciente',
        'id_medico',
        'fecha_cita',
        'hora_cita',
        'motivo',
        'estado',
        'observaciones',
    ];
}
