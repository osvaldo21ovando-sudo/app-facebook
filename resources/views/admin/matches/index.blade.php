<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinculación — Inteligencia Organizacional</title>
    <style>
        :root{
            --azul:#1a56db;--azul-oscuro:#1e429f;--azul-claro:#e8f0fe;
            --gris-fondo:#f4f6f9;--gris-borde:#e2e8f0;--gris-texto:#64748b;
            --texto:#1e293b;--blanco:#ffffff;
            --verde:#059669;--verde-claro:#d1fae5;
            --rojo:#dc2626;--rojo-claro:#fee2e2;
            --amarillo-claro:#fef3c7;
            --radio:8px;--radio-lg:12px;
            --sombra:0 1px 3px rgba(0,0,0,.07);
            --nav-alto:60px;--nav-ancho:240px;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:var(--gris-fondo);color:var(--texto);font-size:14px;}
        .topbar{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-alto);background:var(--blanco);border-bottom:1px solid var(--gris-borde);display:flex;align-items:center;padding:0 24px;gap:16px;}
        .topbar-logo{display:flex;align-items:center;gap:10px;font-size:15px;font-weight:800;color:var(--azul);text-decoration:none;letter-spacing:-.3px;}
        .topbar-logo .li{width:32px;height:32px;background:var(--azul);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;font-weight:900;}
        .topbar-spacer{flex:1;}
        .sidebar{position:fixed;top:var(--nav-alto);left:0;bottom:0;width:var(--nav-ancho);background:var(--blanco);border-right:1px solid var(--gris-borde);padding:16px 0;overflow-y:auto;z-index:90;}
        .sb-sec{padding:8px 16px 4px;font-size:11px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:var(--gris-texto);}
        .sidebar a{display:flex;align-items:center;gap:10px;padding:9px 16px;color:var(--gris-texto);text-decoration:none;font-size:13.5px;transition:background .15s,color .15s;border-left:3px solid transparent;margin:1px 0;}
        .sidebar a:hover{background:var(--gris-fondo);color:var(--texto);}
        .sidebar a.activo{background:var(--azul-claro);color:var(--azul);border-left-color:var(--azul);font-weight:700;}
        .main{margin-top:var(--nav-alto);margin-left:var(--nav-ancho);padding:28px;}
        .ph{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;}
        .ph h1{font-size:21px;font-weight:800;letter-spacing:-.4px;}
        .ph p{font-size:13px;color:var(--gris-texto);margin-top:2px;}
        .alerta{padding:11px 14px;border-radius:var(--radio);font-size:13px;margin-bottom:18px;display:flex;align-items:center;gap:8px;}
        .alerta-exito{background:var(--verde-claro);color:#065f46;border:1px solid #a7f3d0;}
        .card{background:var(--blanco);border:1px solid var(--gris-borde);border-radius:var(--radio-lg);box-shadow:var(--sombra);margin-bottom:20px;}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--gris-borde);display:flex;align-items:center;justify-content:space-between;}
        .card-header h3{font-size:14px;font-weight:700;display:flex;align-items:center;gap:7px;}
        .conteo{display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:22px;padding:0 6px;border-radius:11px;font-size:11px;font-weight:800;background:var(--azul);color:white;}
        .conteo.amarillo{background:#d97706;}
        table{width:100%;border-collapse:collapse;}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--gris-texto);background:var(--gris-fondo);border-bottom:1px solid var(--gris-borde);}
        td{padding:12px 16px;font-size:13.5px;border-bottom:1px solid var(--gris-borde);color:var(--texto);vertical-align:middle;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#fafbfd;}
        .sin-datos{color:var(--gris-texto);text-align:center;padding:28px;font-style:italic;}
        .usuario-fb{display:flex;align-items:center;gap:10px;}
        .usuario-fb img{width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--gris-borde);}
        .usuario-fb .nombre{font-weight:600;font-size:13.5px;}
        .usuario-fb .id{font-size:11.5px;color:var(--gris-texto);font-family:monospace;}
        .miembro-sugerido .nombre{font-weight:600;}
        .miembro-sugerido .estructura{font-size:12px;color:var(--gris-texto);margin-top:1px;}
        .acciones-grupo{display:flex;gap:6px;}
        .btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:var(--radio);border:1px solid transparent;font-size:12.5px;font-weight:600;cursor:pointer;text-decoration:none;transition:all .15s;}
        .btn-ap{background:var(--verde);color:white;border-color:var(--verde);}
        .btn-ap:hover{background:#047857;}
        .btn-re{background:white;color:var(--rojo);border:1px solid #fca5a5;}
        .btn-re:hover{background:var(--rojo-claro);}
        .btn-p{background:var(--azul);color:white;border-color:var(--azul);}
        .btn-p:hover{background:var(--azul-oscuro);}
        select{padding:7px 10px;border:1px solid var(--gris-borde);border-radius:var(--radio);font-size:13px;background:white;color:var(--texto);outline:none;width:100%;}
        select:focus{border-color:var(--azul);box-shadow:0 0 0 3px rgba(26,86,219,.08);}
        .sin-pendientes{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:36px;color:var(--gris-texto);}
        .sin-pendientes .ico{font-size:36px;margin-bottom:10px;}
        .sin-pendientes p{font-size:13px;}
        .flecha-match{color:var(--gris-texto);font-size:18px;}
    </style>
</head>
<body>

<header class="topbar">
    <a href="{{ route('dashboard') }}" class="topbar-logo">
        <div class="li">F</div> Inteligencia Organizacional
    </a>
    <div class="topbar-spacer"></div>
</header>

<aside class="sidebar">
    <div class="sb-sec">Navegación</div>
    <a href="{{ route('dashboard') }}"><span>📊</span> Panel principal</a>
    <a href="{{ route('admin.members.index') }}"><span>👥</span> Miembros</a>
    <a href="{{ route('admin.matches.index') }}" class="activo"><span>🔗</span> Vinculación</a>
</aside>

<main class="main">

    <div class="ph">
        <div>
            <h1>Vinculación de cuentas</h1>
            <p>Aprueba o rechaza vinculaciones automáticas y asigna cuentas manualmente</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alerta alerta-exito">✅ {{ session('success') }}</div>
    @endif

    {{-- Vinculaciones automáticas pendientes --}}
    <div class="card">
        <div class="card-header">
            <h3>
                ⚠️ Vinculaciones automáticas pendientes
                <span class="conteo amarillo">{{ $pendingMatches->count() }}</span>
            </h3>
        </div>

        @if($pendingMatches->isEmpty())
            <div class="sin-pendientes">
                <div class="ico">✅</div>
                <p>No hay vinculaciones pendientes de revisión</p>
            </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Usuario de Facebook</th>
                    <th></th>
                    <th>Miembro sugerido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingMatches as $user)
                <tr>
                    <td>
                        <div class="usuario-fb">
                            <img src="{{ $user->facebook_avatar }}"
                                 alt="{{ $user->facebook_name }}"
                                 onerror="this.style.display='none'">
                            <div>
                                <div class="nombre">{{ $user->facebook_name }}</div>
                                <div class="id">ID: {{ $user->facebook_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align:center" class="flecha-match">→</td>
                    <td>
                        <div class="miembro-sugerido">
                            <div class="nombre">{{ $user->member?->name ?? '—' }}</div>
                            <div class="estructura">{{ $user->member?->politicalStructure?->name ?? 'Sin estructura' }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="acciones-grupo">
                            <form method="POST" action="{{ route('admin.matches.approve', $user) }}">
                                @csrf
                                <button class="btn btn-ap">✓ Aprobar</button>
                            </form>
                            <form method="POST" action="{{ route('admin.matches.reject', $user) }}">
                                @csrf
                                <button class="btn btn-re">✗ Rechazar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Asignación manual --}}
    <div class="card">
        <div class="card-header">
            <h3>
                🔗 Asignación manual
                <span class="conteo">{{ $unmatchedUsers->count() }}</span>
            </h3>
        </div>

        @if($unmatchedUsers->isEmpty())
            <div class="sin-pendientes">
                <div class="ico">🎉</div>
                <p>Todos los usuarios de Facebook están vinculados</p>
            </div>
        @else
        <form method="POST" action="{{ route('admin.matches.assign') }}">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>Usuario de Facebook</th>
                        <th>Asignar al miembro</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unmatchedUsers as $user)
                    <tr>
                        <td>
                            <div class="usuario-fb">
                                <div>
                                    <div class="nombre">{{ $user->facebook_name }}</div>
                                    <div class="id">{{ $user->facebook_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="min-width:220px">
                            <select name="member_id">
                                <option value="">— Seleccionar miembro —</option>
                                @foreach($pendingMembers as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-p">Asignar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        @endif
    </div>

</main>
</body>
</html>
