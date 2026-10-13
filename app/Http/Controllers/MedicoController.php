<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = DB::table('medicos as m')
            ->join('usuarios as u', 'u.id_usuario', '=', 'm.id_usuario')
            ->select(
                'm.id_medico',
                'm.id_usuario',
                'u.nombre_completo',
                'u.correo',
                'm.especialidad',
                'm.numero_colegiatura',
                'm.telefono',
                'm.activo'
            )
            ->orderByDesc('m.id_medico')
            ->paginate(10);

        return view('medicos.index', compact('medicos'));
    }

    private function usuariosDisponibles(?int $idMedico = null)
    {
        $query = DB::table('usuarios as u')
            ->join('roles as r', 'r.id_rol', '=', 'u.id_rol')
            ->where('r.nombre', 'MEDICO')
            ->where('u.activo', 1)
            ->select('u.id_usuario', 'u.nombre_completo', 'u.correo');

        $query->whereNotExists(function ($sub) use ($idMedico) {
            $sub->selectRaw('1')
                ->from('medicos as m')
                ->whereColumn('m.id_usuario', 'u.id_usuario');

            if ($idMedico !== null) {
                $sub->where('m.id_medico', '<>', $idMedico);
            }
        });

        return $query->orderBy('u.nombre_completo')->get();
    }

    public function create()
    {
        return view('medicos.create', [
            'usuarios' => $this->usuariosDisponibles()
        ]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id_usuario',
                'unique:medicos,id_usuario'
            ],
            'especialidad' => 'required|string|max:100',
            'numero_colegiatura' => [
                'nullable',
                'string',
                'max:50',
                'unique:medicos,numero_colegiatura'
            ],
            'telefono' => 'nullable|string|max:30',
            'activo' => 'required|boolean'
        ]);

        Medico::create($datos);

        return redirect()
            ->route('medicos.index')
            ->with('success', 'Médico registrado correctamente.');
    }

    public function edit(Medico $medico)
    {
        return view('medicos.edit', [
            'medico' => $medico,
            'usuarios' => $this->usuariosDisponibles(
                $medico->id_medico
            )
        ]);
    }

    public function update(Request $request, Medico $medico)
    {
        $datos = $request->validate([
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id_usuario',
                Rule::unique('medicos', 'id_usuario')
                    ->ignore($medico->id_medico, 'id_medico')
            ],
            'especialidad' => 'required|string|max:100',
            'numero_colegiatura' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('medicos', 'numero_colegiatura')
                    ->ignore($medico->id_medico, 'id_medico')
            ],
            'telefono' => 'nullable|string|max:30',
            'activo' => 'required|boolean'
        ]);

        $medico->update($datos);

        return redirect()
            ->route('medicos.index')
            ->with('success', 'Médico actualizado correctamente.');
    }

    public function destroy(Medico $medico)
    {
        $tieneDisponibilidad = DB::table('disponibilidad_medica')
            ->where('id_medico', $medico->id_medico)
            ->exists();

        $tieneCitas = DB::table('citas')
            ->where('id_medico', $medico->id_medico)
            ->exists();

        if ($tieneDisponibilidad || $tieneCitas) {
            return redirect()
                ->route('medicos.index')
                ->with(
                    'error',
                    'No se puede eliminar el médico porque tiene horarios o citas asociados.'
                );
        }

        $medico->delete();

        return redirect()
            ->route('medicos.index')
            ->with('success', 'Médico eliminado correctamente.');
    }
}
