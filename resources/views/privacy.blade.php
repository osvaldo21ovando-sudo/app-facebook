{{-- privacy.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de privacidad — Inteligencia Organizacional</title>
    <style>
        :root{--azul:#1a56db;--gris-fondo:#f4f6f9;--gris-borde:#e2e8f0;--gris-texto:#64748b;--texto:#1e293b;--blanco:#ffffff;--radio-lg:12px;}
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:var(--gris-fondo);color:var(--texto);font-size:14px;min-height:100vh;display:flex;flex-direction:column;align-items:center;padding:40px 20px;}
        .logo{display:flex;align-items:center;gap:10px;font-size:15px;font-weight:800;color:var(--azul);margin-bottom:28px;text-decoration:none;}
        .logo .li{width:32px;height:32px;background:var(--azul);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;font-weight:900;}
        .card{background:var(--blanco);border:1px solid var(--gris-borde);border-radius:var(--radio-lg);padding:36px 40px;max-width:640px;width:100%;box-shadow:0 1px 3px rgba(0,0,0,.07);}
        h1{font-size:22px;font-weight:800;letter-spacing:-.4px;margin-bottom:6px;}
        .subtitulo{font-size:13px;color:var(--gris-texto);margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--gris-borde);}
        h2{font-size:15px;font-weight:700;margin:22px 0 8px;}
        p,li{font-size:13.5px;color:var(--gris-texto);line-height:1.8;}
        ul{padding-left:18px;margin-top:4px;}
        li{margin-bottom:4px;}
        .volver{margin-top:20px;font-size:13px;color:var(--azul);text-decoration:none;}
        .volver:hover{text-decoration:underline;}
    </style>
</head>
<body>
    <a href="{{ route('login') }}" class="logo">
        <div class="li">F</div> Inteligencia Organizacional
    </a>
    <div class="card">
        <h1>Política de privacidad</h1>
        <p class="subtitulo">Última actualización: {{ date('d/m/Y') }} · Aplicación de monitoreo de participación en Facebook</p>

        <h2>1. Información que recopilamos</h2>
        <p>Esta aplicación recopila datos básicos de perfil de Facebook (nombre, foto, ID) necesarios para la identificación de miembros del equipo político.</p>

        <h2>2. Uso de la información</h2>
        <ul>
            <li>Identificar y vincular cuentas de Facebook con miembros registrados</li>
            <li>Monitorear la participación en publicaciones oficiales del grupo</li>
            <li>Generar reportes internos de actividad</li>
        </ul>

        <h2>3. Almacenamiento y seguridad</h2>
        <p>Los datos se almacenan en servidores privados de uso exclusivo del equipo administrador. No se comparten con terceros.</p>

        <h2>4. Uso interno exclusivo</h2>
        <p>Esta herramienta es de uso interno exclusivo. Solo el personal autorizado tiene acceso a los datos recopilados.</p>

        <h2>5. Contacto</h2>
        <p>Para cualquier consulta sobre privacidad, contacta al administrador del sistema.</p>
    </div>
    <a href="{{ route('login') }}" class="volver">← Volver al inicio</a>
</body>
</html>
