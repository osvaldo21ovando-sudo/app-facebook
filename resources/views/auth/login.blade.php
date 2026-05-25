<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Inteligencia Organizacional</title>
    <style>
        :root {
            --azul: #1a56db; --azul-oscuro: #1e429f; --azul-claro: #e8f0fe;
            --gris-fondo: #f4f6f9; --gris-borde: #e2e8f0; --gris-texto: #64748b;
            --texto: #1e293b; --rojo-claro: #fee2e2; --azul-info-claro: #dbeafe;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--gris-fondo);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            color: var(--texto);
        }

        /* Panel dividido */
        .login-wrap {
            display: flex; width: 100%; max-width: 820px;
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,.12);
        }

        /* Panel izquierdo — decorativo */
        .panel-izq {
            width: 320px; flex-shrink: 0;
            background: var(--azul);
            padding: 48px 36px;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .panel-izq::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .panel-izq::after {
            content: ''; position: absolute; bottom: -40px; left: -40px;
            width: 160px; height: 160px; border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .logo-izq {
            display: flex; align-items: center; gap: 10px;
            color: white; font-size: 17px; font-weight: 800; letter-spacing: -.4px;
        }
        .logo-izq .icono-logo {
            width: 36px; height: 36px; background: rgba(255,255,255,.18);
            border-radius: 8px; display: flex; align-items: center;
            justify-content: center; font-size: 18px; font-weight: 900;
        }
        .panel-izq-texto {
            position: relative; z-index: 1;
        }
        .panel-izq-texto h2 {
            font-size: 22px; font-weight: 800; color: white;
            line-height: 1.3; margin-bottom: 10px; letter-spacing: -.4px;
        }
        .panel-izq-texto p {
            font-size: 13px; color: rgba(255,255,255,.75); line-height: 1.6;
        }
        .panel-izq-pie {
            font-size: 11px; color: rgba(255,255,255,.45); position: relative; z-index: 1;
        }

        /* Panel derecho — formulario */
        .panel-der {
            flex: 1; background: white; padding: 48px 40px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .panel-der h1 {
            font-size: 20px; font-weight: 800; color: var(--texto);
            letter-spacing: -.4px; margin-bottom: 4px;
        }
        .panel-der .subtitulo {
            font-size: 13px; color: var(--gris-texto); margin-bottom: 28px;
        }

        /* Alertas */
        .alerta { padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; }
        .alerta-error { background: var(--rojo-claro); color: #991b1b; border: 1px solid #fca5a5; }
        .alerta-info  { background: var(--azul-info-claro); color: #1d4ed8; border: 1px solid #bfdbfe; }

        /* Botón Facebook */
        .btn-fb {
            display: flex; align-items: center; justify-content: center; gap: 12px;
            width: 100%; padding: 13px 20px;
            background: #1877f2; color: white;
            border: none; border-radius: 8px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: background .15s, box-shadow .15s;
            box-shadow: 0 2px 8px rgba(24,119,242,.3);
        }
        .btn-fb:hover { background: #1464d8; box-shadow: 0 4px 14px rgba(24,119,242,.35); }
        .btn-fb svg { flex-shrink: 0; }

        /* Divisor */
        .divisor {
            display: flex; align-items: center; gap: 12px; margin: 24px 0;
            color: var(--gris-texto); font-size: 12px;
        }
        .divisor::before, .divisor::after {
            content: ''; flex: 1; height: 1px; background: var(--gris-borde);
        }

        .nota-privacidad {
            font-size: 11.5px; color: var(--gris-texto); text-align: center; line-height: 1.5;
            margin-top: 20px;
        }
        .nota-privacidad a { color: var(--azul); text-decoration: none; }
        .nota-privacidad a:hover { text-decoration: underline; }

        @media(max-width: 640px) {
            .panel-izq { display: none; }
            .login-wrap { border-radius: 12px; }
            .panel-der { padding: 36px 28px; }
        }
    </style>
</head>
<body>
<div class="login-wrap">

    {{-- Panel izquierdo --}}
    <div class="panel-izq">
        <div class="logo-izq">
            <div class="icono-logo">F</div>
            Inteligencia Organizacional
        </div>

        <div class="panel-izq-texto">
            <h2>Monitoreo de participación política</h2>
            <p>Administra la actividad de tus miembros en Facebook de forma eficiente y centralizada.</p>
        </div>

        <div class="panel-izq-pie">
            © {{ date('Y') }} Inteligencia Organizacional · Uso interno exclusivo
        </div>
    </div>

    {{-- Panel derecho --}}
    <div class="panel-der">
        <h1>Iniciar sesión</h1>
        <p class="subtitulo">Accede con tu cuenta de Facebook para continuar</p>

        @if(session('error'))
            <div class="alerta alerta-error">
                ⚠️ {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alerta alerta-info">
                ℹ️ {{ session('info') }}
            </div>
        @endif

        <a href="{{ route('auth.facebook.redirect') }}" class="btn-fb">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            Continuar con Facebook
        </a>

        <div class="divisor">O</div>

        <p class="nota-privacidad">
            Al iniciar sesión aceptas nuestros
            <a href="{{ route('terms') }}">Términos de uso</a> y la
            <a href="{{ route('privacy') }}">Política de privacidad</a>.<br>
            Este sistema es de uso interno y exclusivo del equipo autorizado.
        </p>
    </div>
</div>
</body>
</html>
