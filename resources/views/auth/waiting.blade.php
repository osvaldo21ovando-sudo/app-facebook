<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta en verificación — Inteligencia Organizacional</title>
    <style>
        :root{
            --azul:#1a56db;--azul-oscuro:#1e429f;--azul-claro:#e8f0fe;
            --gris-fondo:#f4f6f9;--gris-borde:#e2e8f0;--gris-texto:#64748b;
            --texto:#1e293b;--blanco:#ffffff;
            --amarillo:#d97706;--amarillo-claro:#fef3c7;
            --radio:8px;--radio-lg:12px;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{
            font-family:'Segoe UI',system-ui,sans-serif;background:var(--gris-fondo);
            min-height:100vh;display:flex;flex-direction:column;align-items:center;
            justify-content:center;color:var(--texto);padding:24px;
        }
        .logo{display:flex;align-items:center;gap:10px;font-size:16px;font-weight:800;color:var(--azul);margin-bottom:32px;}
        .logo .li{width:36px;height:36px;background:var(--azul);border-radius:9px;display:flex;align-items:center;justify-content:center;color:white;font-size:18px;font-weight:900;}
        .card{
            background:var(--blanco);border:1px solid var(--gris-borde);
            border-radius:16px;padding:40px 44px;
            max-width:460px;width:100%;text-align:center;
            box-shadow:0 4px 20px rgba(0,0,0,.08);
        }
        .icono-espera{
            width:64px;height:64px;border-radius:50%;
            background:var(--amarillo-claro);
            display:flex;align-items:center;justify-content:center;
            font-size:28px;margin:0 auto 20px;
        }
        h1{font-size:20px;font-weight:800;letter-spacing:-.4px;margin-bottom:10px;}
        p{font-size:14px;color:var(--gris-texto);line-height:1.7;}
        .separador{height:1px;background:var(--gris-borde);margin:24px 0;}
        .pasos{text-align:left;display:flex;flex-direction:column;gap:12px;}
        .paso{display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--gris-texto);}
        .paso-num{
            width:22px;height:22px;border-radius:50%;
            background:var(--azul-claro);color:var(--azul);
            font-size:11px;font-weight:800;
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
            margin-top:1px;
        }
        .pie{margin-top:28px;font-size:12px;color:var(--gris-texto);}
        .pie a{color:var(--azul);text-decoration:none;}
    </style>
</head>
<body>

    <div class="logo">
        <div class="li">F</div>
        Inteligencia Organizacional
    </div>

    <div class="card">
        <div class="icono-espera">⏳</div>

        <h1>Cuenta en verificación</h1>
        <p>Tu cuenta de Facebook fue reconocida. El administrador debe aprobar tu acceso antes de que puedas usar el sistema.</p>

        <div class="separador"></div>

        <div class="pasos">
            <div class="paso">
                <div class="paso-num">1</div>
                <div>Tu solicitud fue recibida y está en espera de revisión.</div>
            </div>
            <div class="paso">
                <div class="paso-num">2</div>
                <div>El administrador aprobará o rechazará tu acceso.</div>
            </div>
            <div class="paso">
                <div class="paso-num">3</div>
                <div>Una vez aprobado, podrás ingresar con tu cuenta de Facebook.</div>
            </div>
        </div>

        <p class="pie">
            ¿Tienes dudas? Contacta al administrador del sistema.<br>
            <a href="{{ route('login') }}">← Volver al inicio</a>
        </p>
    </div>

</body>
</html>
