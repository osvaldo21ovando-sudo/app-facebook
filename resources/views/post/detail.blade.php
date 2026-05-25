<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de publicación — Inteligencia Organizacional</title>
    <style>
        :root{
            --azul:#1a56db;--azul-oscuro:#1e429f;--azul-claro:#e8f0fe;
            --gris-fondo:#f4f6f9;--gris-borde:#e2e8f0;--gris-texto:#64748b;
            --texto:#1e293b;--blanco:#ffffff;
            --verde:#059669;--verde-claro:#d1fae5;
            --rojo:#dc2626;--rojo-claro:#fee2e2;
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
        .card{background:var(--blanco);border:1px solid var(--gris-borde);border-radius:var(--radio-lg);box-shadow:var(--sombra);margin-bottom:20px;}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--gris-borde);}
        .card-header h3{font-size:14px;font-weight:700;}
        .card-body{padding:20px;}
        .pub-texto{font-size:15px;line-height:1.7;color:var(--texto);margin-bottom:14px;}
        .pub-meta{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
        .pub-meta-item{display:flex;align-items:center;gap:5px;font-size:12.5px;color:var(--gris-texto);}
        .pub-meta-item strong{color:var(--texto);font-weight:700;}
        .separador-v{width:1px;height:16px;background:var(--gris-borde);}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
        @media(max-width:900px){.g2{grid-template-columns:1fr;}}
        .seccion-titulo{font-size:14px;font-weight:700;display:flex;align-items:center;gap:8px;margin-bottom:14px;}
        .conteo-badge{display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:22px;padding:0 7px;border-radius:11px;font-size:11px;font-weight:800;}
        .cb-verde{background:var(--verde-claro);color:#065f46;}
        .cb-rojo{background:var(--rojo-claro);color:#991b1b;}
        table{width:100%;border-collapse:collapse;}
        th{text-align:left;padding:9px 12px;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--gris-texto);background:var(--gris-fondo);border-bottom:1px solid var(--gris-borde);}
        td{padding:10px 12px;font-size:13px;border-bottom:1px solid var(--gris-borde);color:var(--texto);}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#fafbfd;}
        .vacio{color:var(--gris-texto);text-align:center;padding:20px;font-style:italic;}
        .num-reac{font-weight:700;color:var(--verde);}
        .num-com{font-weight:700;color:var(--azul);}
        .est-badge{display:inline-block;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:700;background:var(--gris-fondo);color:var(--gris-texto);}
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
    <a href="{{ route('admin.matches.index') }}"><span>🔗</span> Vinculación</a>
</aside>

<main class="main">

    <a href="{{ route('dashboard') }}" class="volver">← Volver al panel</a>

    {{-- Publicación --}}
    <div class="card">
        <div class="card-header">
            <h3>📄 Detalle de publicación</h3>
        </div>
        <div class="card-body">
            <p class="pub-texto">{{ $post->message ?? $post->story ?? 'Sin texto disponible' }}</p>
            <div class="pub-meta">
                <div class="pub-meta-item">
                    📅 <strong>{{ $post->published_at?->format('d/m/Y H:i') ?? '—' }}</strong>
                </div>
                <div class="separador-v"></div>
                <div class="pub-meta-item">
                    ❤️ <strong>{{ $post->reaction_count }}</strong> reacciones totales
                </div>
                <div class="separador-v"></div>
                <div class="pub-meta-item">
                    💬 <strong>{{ $post->comment_count }}</strong> comentarios totales
                </div>
            </div>
        </div>
    </div>

    {{-- Tablas de participación --}}
    <div class="g2">

        {{-- Interactuaron --}}
        <div class="card">
            <div class="card-header">
                <h3>
                    <div class="seccion-titulo" style="margin:0">
                        <span style="color:var(--verde)">✅</span> Interactuaron
                        <span class="conteo-badge cb-verde">{{ $interacted->count() }}</span>
                    </div>
                </h3>
            </div>
            <div class="card-body" style="padding:0">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Reacciones</th>
                            <th>Comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($interacted as $item)
                        <tr>
                            <td style="font-weight:600">{{ $item['member']->name }}</td>
                            <td class="num-reac">{{ $item['reactions'] }}</td>
                            <td class="num-com">{{ $item['comments'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="vacio">Ningún miembro interactuó</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- No interactuaron --}}
        <div class="card">
            <div class="card-header">
                <h3>
                    <div class="seccion-titulo" style="margin:0">
                        <span style="color:var(--rojo)">❌</span> No interactuaron
                        <span class="conteo-badge cb-rojo">{{ $notInteracted->count() }}</span>
                    </div>
                </h3>
            </div>
            <div class="card-body" style="padding:0">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estructura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notInteracted as $item)
                        <tr>
                            <td style="font-weight:600">{{ $item['member']->name }}</td>
                            <td><span class="est-badge">{{ $item['political_structure'] ?? '—' }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="vacio">🎉 ¡Todos participaron!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
</body>
</html>
