<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar miembro — Inteligencia Organizacional</title>
    <style>
        :root{
            --azul:#1a56db;--azul-oscuro:#1e429f;--azul-claro:#e8f0fe;
            --gris-fondo:#f4f6f9;--gris-borde:#e2e8f0;--gris-texto:#64748b;
            --texto:#1e293b;--blanco:#ffffff;
            --rojo:#dc2626;--rojo-claro:#fee2e2;
            --verde-claro:#d1fae5;--amarillo-claro:#fef3c7;
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
        .volver{display:inline-flex;align-items:center;gap:6px;color:var(--gris-texto);font-size:13px;text-decoration:none;margin-bottom:20px;transition:color .15s;}
        .volver:hover{color:var(--azul);}
        .ph{margin-bottom:24px;display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;}
        .ph h1{font-size:21px;font-weight:800;letter-spacing:-.4px;}
        .ph p{font-size:13px;color:var(--gris-texto);margin-top:2px;}
        .layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;}
        @media(max-width:900px){.layout{grid-template-columns:1fr;}}
        .card{background:var(--blanco);border:1px solid var(--gris-borde);border-radius:var(--radio-lg);box-shadow:var(--sombra);}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--gris-borde);}
        .card-header h3{font-size:14px;font-weight:700;}
        .card-header p{font-size:12.5px;color:var(--gris-texto);margin-top:2px;}
        .card-body{padding:20px;}
        .grupo{margin-bottom:16px;}
        label{display:block;font-size:13px;font-weight:600;color:var(--texto);margin-bottom:5px;}
        .label-hint{font-size:11.5px;color:var(--gris-texto);font-weight:400;margin-left:6px;}
        input[type=text],select{width:100%;padding:9px 12px;border:1px solid var(--gris-borde);border-radius:var(--radio);font-size:13.5px;font-family:inherit;color:var(--texto);background:white;transition:border-color .15s,box-shadow .15s;outline:none;}
        input[type=text]:focus,select:focus{border-color:var(--azul);box-shadow:0 0 0 3px rgba(26,86,219,.09);}
        .error-msg{color:var(--rojo);font-size:12px;margin-top:4px;}
        .alerta-error{background:var(--rojo-claro);color:#991b1b;border:1px solid #fca5a5;padding:12px 14px;border-radius:var(--radio);font-size:13px;margin-bottom:16px;}
        .alerta-error ul{padding-left:18px;margin-top:6px;}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radio);border:1px solid transparent;font-size:13.5px;font-weight:600;cursor:pointer;text-decoration:none;transition:all .15s;}
        .btn-p{background:var(--azul);color:white;border-color:var(--azul);}
        .btn-p:hover{background:var(--azul-oscuro);}
        .btn-sec{background:white;color:var(--texto);border-color:var(--gris-borde);}
        .btn-sec:hover{background:var(--gris-fondo);}
        .form-pie{display:flex;gap:10px;padding-top:16px;border-top:1px solid var(--gris-borde);margin-top:4px;}
        .separador{height:1px;background:var(--gris-borde);margin:16px 0;}
        .badge{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;}
        .badge-linked{background:var(--verde-claro);color:#065f46;}
        .badge-pending{background:var(--amarillo-claro);color:#92400e;}
        .badge-inactive{background:#f1f5f9;color:#475569;}
        .resumen-miembro{background:var(--gris-fondo);border-radius:var(--radio-lg);padding:16px;margin-bottom:16px;}
        .resumen-nombre{font-size:15px;font-weight:800;color:var(--texto);}
        .resumen-dato{font-size:12.5px;color:var(--gris-texto);margin-top:2px;}
        .estado-opciones{display:flex;flex-direction:column;gap:8px;}
        .estado-opcion{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid var(--gris-borde);border-radius:var(--radio);cursor:pointer;transition:all .15s;}
        .estado-opcion:hover{border-color:var(--azul);background:var(--azul-claro);}
        .estado-opcion input[type=radio]{accent-color:var(--azul);}
        .estado-opcion-texto{font-size:13px;font-weight:600;}
        .estado-opcion-desc{font-size:11.5px;color:var(--gris-texto);}
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
    <a href="{{ route('admin.members.index') }}" class="activo"><span>👥</span> Miembros</a>
    <a href="{{ route('admin.matches.index') }}"><span>🔗</span> Vinculación</a>
</aside>

<main class="main">

    <a href="{{ route('admin.members.index') }}" class="volver">← Volver a miembros</a>

    <div class="ph">
        <div>
            <h1>Editar miembro</h1>
            <p>Modifica la información de {{ $member->name }}</p>
        </div>
        <span class="badge badge-{{ $member->status }}">
            {{ match($member->status) {
                'linked'   => 'Vinculado',
                'pending'  => 'Pendiente',
                'inactive' => 'Inactivo',
                default    => $member->status,
            } }}
        </span>
    </div>

    @if($errors->any())
        <div class="alerta-error">
            ⚠️ Por favor corrige los siguientes errores:
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="layout">

        {{-- Formulario principal --}}
        <div class="card">
            <div class="card-header">
                <h3>Datos del miembro</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.members.update', $member) }}" id="form-editar">
                    @csrf
                    @method('PUT')

                    <div class="grupo">
                        <label>Nombre completo *</label>
                        <input type="text" name="name" value="{{ old('name', $member->name) }}" required>
                        @error('name')<div class="error-msg">⚠ {{ $message }}</div>@enderror
                    </div>

                    <div class="grupo">
                        <label>Estructura política</label>
                        <select name="political_structure_id">
                            <option value="">— Sin asignar —</option>
                            @foreach($structures as $structure)
                                <option value="{{ $structure->id }}"
                                    {{ $member->political_structure_id == $structure->id ? 'selected' : '' }}>
                                    {{ $structure->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="separador"></div>

                    <div class="grupo">
                        <label>Cargo <span class="label-hint">Opcional</span></label>
                        <input type="text" name="position" value="{{ old('position', $member->position) }}"
                               placeholder="Ej. Coordinador, Delegado">
                    </div>

                    <div class="grupo">
                        <label>Teléfono <span class="label-hint">Opcional</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                               placeholder="Ej. +52 55 1234 5678">
                    </div>

                    <div class="separador"></div>

                    <div class="grupo">
                        <label>Facebook ID <span class="label-hint">Identificador numérico</span></label>
                        <input type="text" name="facebook_id"
                               value="{{ old('facebook_id', $member->facebook_id) }}"
                               placeholder="Ej. 123456789012345">
                    </div>

                    <div class="grupo">
                        <label>Estado del miembro</label>
                        <select name="status" required>
                            <option value="pending"  {{ $member->status === 'pending'  ? 'selected' : '' }}>Pendiente</option>
                            <option value="linked"   {{ $member->status === 'linked'   ? 'selected' : '' }}>Vinculado</option>
                            <option value="inactive" {{ $member->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-pie">
                        <button type="submit" class="btn btn-p">✓ Guardar cambios</button>
                        <a href="{{ route('admin.members.index') }}" class="btn btn-sec">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Panel lateral --}}
        <div style="display:flex;flex-direction:column;gap:16px;">
            <div class="card">
                <div class="card-header">
                    <h3>Resumen</h3>
                </div>
                <div class="card-body">
                    <div class="resumen-miembro">
                        <div class="resumen-nombre">{{ $member->name }}</div>
                        <div class="resumen-dato">{{ $member->politicalStructure?->name ?? 'Sin estructura' }}</div>
                        <div class="resumen-dato" style="margin-top:6px">
                            Registrado: {{ $member->created_at?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>
                    @if($member->facebook_id)
                        <div style="background:var(--verde-claro);padding:10px 12px;border-radius:var(--radio);font-size:12.5px;color:#065f46;">
                            ✅ Cuenta de Facebook vinculada<br>
                            <span style="font-family:monospace;font-size:11px;opacity:.8">{{ $member->facebook_id }}</span>
                        </div>
                    @else
                        <div style="background:var(--amarillo-claro);padding:10px 12px;border-radius:var(--radio);font-size:12.5px;color:#92400e;">
                            ⚠️ Sin Facebook ID asignado.<br>
                            Puedes asignarlo en <a href="{{ route('admin.matches.index') }}" style="color:#92400e;font-weight:700;">Vinculación</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>
</body>
</html>
