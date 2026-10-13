<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Clínica Salud Ágil</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            background: #edf4f8;
            color: #17324d;
            font-family: Arial, sans-serif;
        }
        .card {
            width: 100%;
            max-width: 420px;
            padding: 36px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 12px 35px #17324d18;
        }
        .logo {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #087e8b;
            color: white;
            font-weight: bold;
            margin-bottom: 22px;
        }
        h1 { font-size: 25px; margin: 0 0 8px; }
        .subtitle { color: #64748b; margin-bottom: 28px; }
        label { display: block; margin: 18px 0 7px; font-weight: bold; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 16px;
        }
        input:focus { outline: 2px solid #087e8b; border-color: transparent; }
        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: 0;
            border-radius: 8px;
            background: #087e8b;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover { background: #066874; }
        .error {
            padding: 12px;
            border-radius: 8px;
            background: #fff1f2;
            color: #9f1239;
            font-size: 14px;
        }
        footer { margin-top: 24px; color: #64748b; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <main class="card">
        <div class="logo">CSA</div>
        <h1>Clínica Salud Ágil</h1>
        <p class="subtitle">Acceso para personal autorizado</p>

        @if ($errors->any())
            <div class="error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="correo">Correo electrónico</label>
            <input
                id="correo"
                name="correo"
                type="email"
                value="{{ old('correo') }}"
                autocomplete="username"
                maxlength="150"
                required
                autofocus
            >

            <label for="contrasena">Contraseña</label>
            <input
                id="contrasena"
                name="contrasena"
                type="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Iniciar sesión</button>
        </form>

        <footer>Sistema de gestión de pacientes, médicos y citas</footer>
    </main>
</body>
</html>
