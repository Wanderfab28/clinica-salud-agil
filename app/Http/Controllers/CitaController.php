<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    public function index()
    {
        $citas = DB::table('citas as c')
            ->join('pacientes as p', 'p.id_paciente', '=', 'c.id_paciente')
            ->join('medicos as m', 'm.id_medico', '=', 'c.id_medico')
            ->join('usuarios as u', 'u.id_usuario', '=', 'm.id_usuario')
            ->select(
                'c.id_cita',
                'c.fecha_cita',
                'c.hora_cita',
                'c.motivo',
                'c.estado',
                'c.observaciones',
                'p.nombre_completo as paciente',
                'u.nombre_completo as medico',
                'm.especialidad'
            )
            ->orderByDesc('c.fecha_cita')
            ->orderByDesc('c.hora_cita')
            ->paginate(15);

        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $pacientes = DB::table('pacientes')
            ->select('id_paciente', 'nombre_completo')
            ->orderBy('nombre_completo')
            ->get();

        $medicos = DB::table('medicos as m')
            ->join('usuarios as u', 'u.id_usuario', '=', 'm.id_usuario')
            ->where('m.activo', 1)
            ->select(
                'm.id_medico',
                'm.especialidad',
                'u.nombre_completo'
            )
            ->orderBy('u.nombre_completo')
            ->get();

        return view('citas.create', compact('pacientes', 'medicos'));
    }

    private function validarDatos(Request $request, ?Cita $cita = null)
    {
        return $request->validate([
            'id_paciente' => 'required|integer|exists:pacientes,id_paciente',
            'id_medico' => 'required|integer|exists:medicos,id_medico',
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required|date_format:H:i',
            'motivo' => 'nullable|string|max:500',
            'estado' => 'required|in:PROGRAMADA,CONFIRMADA,ATENDIDA,CANCELADA,NO_ASISTIO',
            'observaciones' => 'nullable|string|max:1000',
        ]);
    }

    private function horarioOcupado(
        int $idMedico,
        string $fecha,
        string $hora,
        ?int $excepto = null
    ): bool {
        $consulta = DB::table('citas')
            ->where('id_medico', $idMedico)
            ->where('fecha_cita', $fecha)
            ->where('hora_cita', $hora)
            ->where('estado', '<>', 'CANCELADA');

        if ($excepto !== null) {
            $consulta->where('id_cita', '<>', $excepto);
        }

        return $consulta->exists();
    }

    public function store(Request $request)
    {
        $datos = $this->validarDatos($request);

        if ($datos['estado'] !== 'CANCELADA' &&
            $this->horarioOcupado(
                (int) $datos['id_medico'],
                $datos['fecha_cita'],
                $datos['hora_cita']
            )) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora_cita' => 'El medico ya tiene una cita en esa fecha y hora.'
                ]);
        }

        Cita::create($datos);

        return redirect()
            ->route('citas.index')
            ->with('success', 'Cita registrada correctamente.');
    }

    public function edit(Cita $cita)
    {
        $pacientes = DB::table('pacientes')
            ->select('id_paciente', 'nombre_completo')
            ->orderBy('nombre_completo')
            ->get();

        $medicos = DB::table('medicos as m')
            ->join('usuarios as u', 'u.id_usuario', '=', 'm.id_usuario')
            ->where(function ($consulta) use ($cita) {
                $consulta->where('m.activo', 1)
                    ->orWhere('m.id_medico', $cita->id_medico);
            })
            ->select(
                'm.id_medico',
                'm.especialidad',
                'u.nombre_completo'
            )
            ->orderBy('u.nombre_completo')
            ->get();

        return view('citas.edit', compact('cita', 'pacientes', 'medicos'));
    }

    public function update(Request $request, Cita $cita)
    {
        $datos = $this->validarDatos($request, $cita);

        if ($datos['estado'] !== 'CANCELADA' &&
            $this->horarioOcupado(
                (int) $datos['id_medico'],
                $datos['fecha_cita'],
                $datos['hora_cita'],
                $cita->id_cita
            )) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora_cita' => 'El medico ya tiene otra cita en esa fecha y hora.'
                ]);
        }

        $cita->update($datos);

        return redirect()
            ->route('citas.index')
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        if (in_array($cita->estado, ['ATENDIDA', 'NO_ASISTIO'], true)) {
            return redirect()
                ->route('citas.index')
                ->with('error', 'No se puede cancelar una cita ya finalizada.');
        }

        $cita->update(['estado' => 'CANCELADA']);

        return redirect()
            ->route('citas.index')
            ->with('success', 'Cita cancelada correctamente.');
    }
}
