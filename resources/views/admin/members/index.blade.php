<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros — Inteligencia Organizacional</title>
    <style>
        :root{
            --azul:#1a56db;--azul-oscuro:#1e429f;--azul-claro:#e8f0fe;
            --gris-fondo:#f4f6f9;--gris-borde:#e2e8f0;--gris-texto:#64748b;
            --texto:#1e293b;--blanco:#ffffff;
            --verde:#059669;--verde-claro:#d1fae5;
            --rojo:#dc2626;--rojo-claro:#fee2e2;
            --amarillo-claro:#fef3c7;
            --radio:8px;--radio-lg:12px;
            --sombra:0 1px 3px rgba(0,0,0,.07),0 1px 2px rgba(0,0,0,.04);
            --nav-alto:60px;--nav-ancho:240px;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:var(--gris-fondo);color:var(--texto);font-size:14px;}
        .topbar{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-alto);background:var(--blanco);border-bottom:1px solid var(--gris-borde);display:flex;align-items:center;padding:0 24px;gap:16px;}
        .topbar-logo{display:flex;align-items:center;gap:10px;font-size:15px;font-weight:800;color:var(--azul);text-decoration:none;letter-spacing:-.3px;}
        .topbar-logo .li{width:32px;height:32px;background:var(--azul);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;font-weight:900;}
        .topbar-spacer{flex:1;}
        .topbar-user{display:flex;align-items:center;gap:10px;font-size:13px;color:var(--gris-texto);}
        .topbar-user .av{width:32px;height:32px;border-radius:50%;background:var(--azul-claro);color:var(--azul);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;}
        .sidebar{position:fixed;top:var(--nav-alto);left:0;bottom:0;width:var(--nav-ancho);background:var(--blanco);border-right:1px solid var(--gris-borde);padding:16px 0;overflow-y:auto;z-index:90;}
        .sb-sec{padding:8px 16px 4px;font-size:11px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:var(--gris-texto);}
        .sidebar a{display:flex;align-items:center;gap:10px;padding:9px 16px;color:var(--gris-texto);text-decoration:none;font-size:13.5px;transition:background .15s,color .15s;border-left:3px solid transparent;margin:1px 0;}
        .sidebar a:hover{background:var(--gris-fondo);color:var(--texto);}
        .sidebar a.activo{background:var(--azul-claro);color:var(--azul);border-left-color:var(--azul);font-weight:700;}
        .main{margin-top:var(--nav-alto);margin-left:var(--nav-ancho);padding:28px;min-height:calc(100vh - var(--nav-alto));}
        .ph{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;flex-wrap:wrap;}
        .ph h1{font-size:21px;font-weight:800;letter-spacing:-.4px;}
        .ph p{font-size:13px;color:var(--gris-texto);margin-top:2px;}
        .alerta{padding:11px 14px;border-radius:var(--radio);font-size:13px;margin-bottom:18px;display:flex;align-items:center;gap:8px;}
        .alerta-exito{background:var(--verde-claro);color:#065f46;border:1px solid #a7f3d0;}
        .card{background:var(--blanco);border:1px solid var(--gris-borde);border-radius:var(--radio-lg);box-shadow:var(--sombra);}
        .card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--gris-borde);}
        .card-header h3{font-size:14px;font-weight:700;}
        .card-body{padding:0;}
        table{width:100%;border-collapse:collapse;}
        th{text-align:left;padding:10px 16px;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--gris-texto);background:var(--gris-fondo);border-bottom:1px solid var(--gris-borde);}
        td{padding:12px 16px;font-size:13.5px;border-bottom:1px solid var(--gris-borde);color:var(--texto);vertical-align:middle;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#fafbfd;}
        td.vacio{color:var(--gris-texto);text-align:center;padding:32px;font-style:italic;}
        .badge{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;}
        .badge::before{content:'';display:inline-block;width:6px;height:6px;border-radius:50%;}
        .badge-linked{background:var(--verde-claro);color:#065f46;}
        .badge-linked::before{background:#059669;}
        .badge-pending{background:var(--amarillo-claro);color:#92400e;}
        .badge-pending::before{background:#d97706;}
        .badge-inactive{background:#f1f5f9;color:#475569;}
        .badge-inactive::before{background:#94a3b8;}
        .fb-id{font-family:monospace;font-size:12px;color:var(--gris-texto);background:var(--gris-fondo);padding:2px 6px;border-radius:4px;}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 13px;border-radius:var(--radio);border:1px solid transparent;font-size:12.5px;font-weight:600;cursor:pointer;text-decoration:none;transition:all .15s;}
        .btn-p{background:var(--azul);color:white;border-color:var(--azul);}
        .btn-p:hover{background:var(--azul-oscuro);}
        .btn-sm{padding:5px 11px;font-size:12px;}
        .btn-sec{background:white;color:var(--texto);border-color:var(--gris-borde);}
        .btn-sec:hover{background:var(--gris-fondo);}
        .filtro-bar{display:flex;align-items:center;gap:10px;padding:14px 20px;border-bottom:1px solid var(--gris-borde);background:var(--gris-fondo);border-radius:var(--radio-lg) var(--radio-lg) 0 0;}
        input[type=text]{padding:7px 11px;border:1px solid var(--gris-borde);border-radius:var(--radio);font-size:13px;font-family:inherit;color:var(--texto);background:white;outline:none;transition:border-color .15s;}
        input[type=text]:focus{border-color:var(--azul);box-shadow:0 0 0 3px rgba(26,86,219,.08);}
        .miembro-nombre{font-weight:600;}
        .miembro-cargo{font-size:12px;color:var(--gris-texto);margin-top:1px;}
        .pag{margin-top:16px;padding:12px 20px;display:flex;justify-content:flex-end;}
    </style>
</head>
<body>

<header class="topbar">
    <a href="{{ route('dashboard') }}" class="topbar-logo">
        <div class="li">F</div> Inteligencia Organizacional
    </a>
    <div class="topbar-spacer"></div>
    <div class="topbar-user">
        <div class="av">AD</div>
        Administrador
    </div>
</header>

<aside class="sidebar">
    <div class="sb-sec">Navegación</div>
    <a href="{{ route('dashboard') }}"><span>📊</span> Panel principal</a>
    <a href="{{ route('admin.members.index') }}" class="activo"><span>👥</span> Miembros</a>
    <a href="{{ route('admin.matches.index') }}"><span>🔗</span> Vinculación</a>
    <div class="sb-sec" style="margin-top:12px">Sistema</div>
    <a href="{{ route('privacy') }}"><span>🔒</span> Privacidad</a>
    <a href="{{ route('terms') }}"><span>📄</span> Términos</a>
</aside>

<main class="main">

    <div class="ph">
        <div>
            <h1>Miembros del equipo</h1>
            <p>Gestiona los miembros y su vinculación con Facebook</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn btn-p">
            + Agregar miembro
        </a>
    </div>

    @if(session('success'))
        <div class="alerta alerta-exito">✅ {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="filtro-bar">
            <input type="text" placeholder="Buscar miembro..." id="buscar" style="width:280px">
            <select style="padding:7px 11px;border:1px solid var(--gris-borde);border-radius:var(--radio);font-size:13px;background:white;color:var(--texto);outline:none;">
                <option value="">Todos los estados</option>
                <option value="linked">Vinculados</option>
                <option value="pending">Pendientes</option>
                <option value="inactive">Inactivos</option>
            </select>
        </div>
        <div class="card-body">
            <table id="tabla-miembros">
                <thead>
                    <tr>
                        <th>Miembro</th>
                        <th>Estructura</th>
                        <th>Estado</th>
                        <th>Facebook ID</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr>
                        <td>
                            <div class="miembro-nombre">{{ $member->name }}</div>
                            @if($member->position)
                                <div class="miembro-cargo">{{ $member->position }}</div>
                            @endif
                        </td>
                        <td>{{ $member->politicalStructure?->name ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $member->status }}">
                                {{ match($member->status) {
                                    'linked'   => 'Vinculado',
                                    'pending'  => 'Pendiente',
                                    'inactive' => 'Inactivo',
                                    default    => $member->status,
                                } }}
                            </span>
                        </td>
                        <td>
                            @if($member->facebook_id)
                                <span class="fb-id">{{ $member->facebook_id }}</span>
                            @else
                                <span style="color:var(--gris-texto);font-style:italic;font-size:12px">Sin vincular</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sec btn-sm">
                                ✏️ Editar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="vacio">No hay miembros registrados</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pag">{{ $members->links() }}</div>
    </div>

</main>

<script>
document.getElementById('buscar').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tabla-miembros tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
</body>
</html>
