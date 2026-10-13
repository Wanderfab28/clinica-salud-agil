<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::orderBy('id_paciente', 'desc')
            ->paginate(10);

        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'documento_identidad' =>
                'required|string|max:30|unique:pacientes,documento_identidad',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
        ]);

        Paciente::create($datos);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $datos = $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'documento_identidad' => [
                'required',
                'string',
                'max:30',
                Rule::unique('pacientes', 'documento_identidad')
                    ->ignore($paciente->id_paciente, 'id_paciente'),
            ],
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
        ]);

        $paciente->update($datos);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $tieneCitas = DB::table('citas')
            ->where('id_paciente', $paciente->id_paciente)
            ->exists();

        if ($tieneCitas) {
            return redirect()
                ->route('pacientes.index')
                ->with(
                    'error',
                    'No se puede eliminar este paciente porque tiene citas asociadas.'
                );
        }

        $paciente->delete();

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }
}
