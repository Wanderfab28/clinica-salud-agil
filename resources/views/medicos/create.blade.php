<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar médico | Clínica Salud Ágil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }
        .contenedor {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
        }
        h1 { color: #1769aa; }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }
        .boton {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #1769aa;
            color: white;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        .error {
            padding: 12px;
            background: #ffebee;
            color: #b71c1c;
            border-radius: 6px;
        }
        .aviso {
            padding: 12px;
            background: #fff7ed;
            color: #9a3412;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Clínica Salud Ágil</h1>
    <h2>Registrar médico</h2>
    <p>Completa los datos profesionales del médico.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Revisa los siguientes errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($usuarios->isEmpty())
        <div class="aviso">
            No hay usuarios con el rol MEDICO disponibles para registrar.
            Comprueba que exista un usuario activo con ese rol y que todavía
            no tenga una ficha médica asociada.
        </div>
    @endif

    <form method="POST" action="{{ route('medicos.store') }}">
        @csrf

        <label for="id_usuario">Usuario médico *</label>
        <select id="id_usuario" name="id_usuario" required>
            <option value="">Seleccionar usuario</option>
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}"
                    {{ (string)old('id_usuario') === (string)$usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre_completo }} — {{ $usuario->correo }}
                </option>
            @endforeach
        </select>

        <label for="especialidad">Especialidad *</label>
        <input
            id="especialidad"
            name="especialidad"
            maxlength="100"
            value="{{ old('especialidad') }}"
            placeholder="Ej.: Medicina General"
            required
        >

        <label for="numero_colegiatura">Número de colegiatura</label>
        <input
            id="numero_colegiatura"
            name="numero_colegiatura"
            maxlength="50"
            value="{{ old('numero_colegiatura') }}"
            placeholder="Ej.: MED-002"
        >

        <label for="telefono">Teléfono</label>
        <input
            id="telefono"
            name="telefono"
            maxlength="30"
            value="{{ old('telefono') }}"
            placeholder="Ej.: 809-555-0102"
        >

        <label for="activo">Estado *</label>
        <select id="activo" name="activo" required>
            <option value="1" selected>Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <button
            class="boton"
            type="submit"
            {{ $usuarios->isEmpty() ? 'disabled' : '' }}
        >
            Guardar médico
        </button>

        <a class="boton" href="{{ route('medicos.index') }}">Cancelar</a>
    </form>
</div>
</body>
</html>
