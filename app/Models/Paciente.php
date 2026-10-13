<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Paciente extends Model
{
protected $table = 'pacientes';
protected $primaryKey = 'id_paciente';
public $timestamps = false;
protected $fillable = ['nombre_completo', 'documento_identidad', 'fecha_nacimiento', 'sexo', 'telefono', 'correo', 'direccion'];
public function getRouteKeyName(): string
{
return 'id_paciente';
}
}
