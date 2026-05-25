<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal — Inteligencia Organizacional</title>

    <style>
        :root{
            --azul:#2563eb;
            --azul-oscuro:#1d4ed8;
            --azul-claro:#dbeafe;

            --gris-fondo:#f1f5f9;
            --gris-borde:#e2e8f0;
            --gris-texto:#64748b;

            --texto:#0f172a;
            --blanco:#ffffff;

            --verde:#10b981;
            --rojo:#ef4444;

            --radio:14px;
            --radio-lg:22px;

            --sombra:
                0 10px 30px rgba(15,23,42,.06);

            --nav-alto:70px;
            --nav-ancho:250px;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            scroll-behavior:smooth;
        }

        body{
            font-family:
                Inter,
                "Segoe UI",
                system-ui,
                sans-serif;

            background:
                radial-gradient(circle at top left,#dbeafe 0%,transparent 25%),
                radial-gradient(circle at bottom right,#e0f2fe 0%,transparent 20%),
                var(--gris-fondo);

            color:var(--texto);
        }

        /* TOPBAR */

        .topbar{
            position:fixed;
            top:0;
            left:0;
            right:0;

            z-index:100;

            height:var(--nav-alto);

            background:rgba(255,255,255,.82);

            backdrop-filter:blur(14px);

            border-bottom:1px solid rgba(255,255,255,.35);

            display:flex;
            align-items:center;

            padding:0 28px;

            box-shadow:
                0 4px 20px rgba(15,23,42,.04);
        }

        .topbar-logo{
            display:flex;
            align-items:center;
            gap:12px;

            text-decoration:none;

            font-size:18px;
            font-weight:800;

            color:var(--texto);
        }

        .topbar-logo .li{
            width:42px;
            height:42px;

            border-radius:14px;

            background:linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            display:flex;
            align-items:center;
            justify-content:center;

            color:white;

            font-weight:900;
            font-size:18px;

            box-shadow:
                0 10px 20px rgba(37,99,235,.35);
        }

        .topbar-spacer{
            flex:1;
        }

        .topbar-user{
            display:flex;
            align-items:center;
            gap:12px;

            font-size:14px;
            color:var(--gris-texto);
        }

        .av{
            width:40px;
            height:40px;

            border-radius:50%;

            background:linear-gradient(
                135deg,
                #2563eb,
                #60a5fa
            );

            color:white;

            display:flex;
            align-items:center;
            justify-content:center;

            font-weight:800;
        }

        .btn-salir{
            border:none;

            padding:10px 16px;

            border-radius:12px;

            background:#eff6ff;

            color:var(--azul);

            cursor:pointer;

            font-weight:700;

            transition:all .2s ease;
        }

        .btn-salir:hover{
            transform:translateY(-2px);

            background:var(--azul);

            color:white;
        }

        /* SIDEBAR */

        .sidebar{
            position:fixed;

            top:var(--nav-alto);
            left:0;
            bottom:0;

            width:var(--nav-ancho);

            background:linear-gradient(
                180deg,
                #0f172a,
                #111827
            );

            padding:22px 0;

            overflow-y:auto;

            box-shadow:
                4px 0 20px rgba(15,23,42,.08);
        }

        .sb-sec{
            padding:12px 24px;

            color:#64748b;

            font-size:11px;
            font-weight:700;

            text-transform:uppercase;

            letter-spacing:1px;
        }

        .sidebar a{
            display:flex;
            align-items:center;
            gap:12px;

            margin:6px 14px;
            padding:13px 16px;

            border-radius:16px;

            text-decoration:none;

            color:#cbd5e1;

            font-size:14px;
            font-weight:500;

            transition:all .2s ease;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,.08);

            color:white;

            transform:translateX(4px);
        }

        .sidebar a.activo{
            background:linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color:white;

            font-weight:700;

            box-shadow:
                0 10px 20px rgba(37,99,235,.35);
        }

        .sidebar .ic{
            font-size:18px;
        }

        /* MAIN */

        .main{
            margin-left:var(--nav-ancho);
            margin-top:var(--nav-alto);

            padding:34px;
        }

        /* PAGE HEADER */

        .ph{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;

            margin-bottom:30px;
        }

        .ph h1{
            font-size:36px;
            font-weight:900;

            background:linear-gradient(
                90deg,
                #0f172a,
                #2563eb
            );

            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .ph p{
            margin-top:6px;

            color:var(--gris-texto);

            font-size:15px;
        }

        /* ALERTA */

        .alerta{
            padding:14px 18px;

            border-radius:16px;

            margin-bottom:24px;

            font-size:14px;
            font-weight:600;
        }

        .alerta-exito{
            background:#dcfce7;
            color:#166534;
        }

        /* METRICAS */

        .grid-m{
            display:grid;

            grid-template-columns:
                repeat(auto-fit,minmax(220px,1fr));

            gap:18px;

            margin-bottom:28px;
        }

        .met{
            position:relative;

            overflow:hidden;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f8fafc
                );

            border-radius:24px;

            padding:24px;

            box-shadow:var(--sombra);

            transition:all .25s ease;
        }

        .met:hover{
            transform:
                translateY(-4px)
                scale(1.01);

            box-shadow:
                0 18px 40px rgba(15,23,42,.12);
        }

        .met::before{
            content:'';

            position:absolute;

            top:-40px;
            right:-40px;

            width:120px;
            height:120px;

            border-radius:50%;

            background:
                rgba(37,99,235,.08);
        }

        .met-ico{
            font-size:30px;

            margin-bottom:12px;
        }

        .met-val{
            font-size:38px;
            font-weight:900;

            line-height:1;
        }

        .met-val.az{
            color:var(--azul);
        }

        .met-val.vd{
            color:var(--verde);
        }

        .met-val.rd{
            color:var(--rojo);
        }

        .met-lbl{
            margin-top:8px;

            color:var(--gris-texto);

            font-size:14px;
            font-weight:500;
        }

        /* GRID */

        .g2{
            display:grid;

            grid-template-columns:1fr 1fr;

            gap:22px;
        }

        @media(max-width:1100px){
            .g2{
                grid-template-columns:1fr;
            }

            .sidebar{
                display:none;
            }

            .main{
                margin-left:0;
            }
        }

        /* CARD */

        .card{
            background:rgba(255,255,255,.92);

            backdrop-filter:blur(10px);

            border:1px solid rgba(255,255,255,.45);

            border-radius:24px;

            padding:24px;

            box-shadow:var(--sombra);

            transition:all .25s ease;
        }

        .card:hover{
            transform:translateY(-3px);

            box-shadow:
                0 18px 40px rgba(15,23,42,.10);
        }

        .card h3{
            display:flex;
            align-items:center;
            gap:10px;

            margin-bottom:18px;

            font-size:18px;
            font-weight:800;
        }

        /* TABLAS */

        table{
            width:100%;

            border-collapse:separate;
            border-spacing:0 10px;
        }

        th{
            text-align:left;

            padding:10px 14px;

            font-size:11px;
            font-weight:800;

            text-transform:uppercase;

            letter-spacing:.8px;

            color:var(--gris-texto);
        }

        tbody tr{
            transition:all .18s ease;
        }

        tbody tr:hover{
            transform:scale(1.01);

            box-shadow:
                0 6px 18px rgba(15,23,42,.06);
        }

        td{
            background:white;

            padding:14px;

            font-size:14px;

            border-top:1px solid #f1f5f9;
            border-bottom:1px solid #f1f5f9;
        }

        td:first-child{
            border-radius:14px 0 0 14px;
        }

        td:last-child{
            border-radius:0 14px 14px 0;
        }

        td a{
            color:var(--azul);

            text-decoration:none;

            font-weight:700;
        }

        td a:hover{
            text-decoration:underline;
        }

        .vacio{
            text-align:center;

            color:var(--gris-texto);

            font-style:italic;
        }

        /* RANK */

        .rank-num{
            width:30px;
            height:30px;

            border-radius:50%;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:12px;
            font-weight:800;

            background:#eff6ff;

            color:var(--azul);
        }

        .rank-num.top{
            background:linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color:white;
        }

        /* LEYENDA */

        .leyenda{
            display:flex;
            gap:18px;

            margin-bottom:16px;

            flex-wrap:wrap;
        }

        .leyenda-item{
            display:flex;
            align-items:center;
            gap:7px;

            color:var(--gris-texto);

            font-size:13px;
        }

        .leyenda-dot{
            width:12px;
            height:12px;

            border-radius:50%;
        }

        .dot-fb{
            background:#1877f2;
        }

        .dot-team{
            background:#10b981;
        }

        /* BOTONES */

        .sync-grid{
            display:flex;
            flex-wrap:wrap;
            gap:12px;
        }

        .btn-sync{
            display:inline-flex;
            align-items:center;
            gap:8px;

            padding:12px 18px;

            border:none;

            border-radius:16px;

            background:linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color:white;

            font-size:13px;
            font-weight:700;

            cursor:pointer;

            transition:all .2s ease;

            box-shadow:
                0 10px 20px rgba(37,99,235,.25);
        }

        .btn-sync:hover{
            transform:translateY(-2px);

            box-shadow:
                0 14px 28px rgba(37,99,235,.35);
        }

        .num-fb{
            color:#1877f2;
            font-weight:700;
        }

        .num-team{
            color:#10b981;
            font-weight:700;
        }
    </style>
</head>

<body>

<header class="topbar">

    <a href="{{ route('dashboard') }}" class="topbar-logo">
        <div class="li">F</div>
        Inteligencia Organizacional
    </a>

    <div class="topbar-spacer"></div>

    <div class="topbar-user">

        <div class="av">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
        </div>

        {{ auth()->user()->name ?? 'Administrador' }}

        <form method="POST" action="{{ route('auth.facebook.logout') }}">
            @csrf

            <button type="submit" class="btn-salir">
                Cerrar sesión
            </button>
        </form>

    </div>

</header>

<aside class="sidebar">

    <div class="sb-sec">
        Navegación
    </div>

    <a href="{{ route('dashboard') }}" class="activo">
        <span class="ic">📊</span>
        Panel principal
    </a>

    <a href="{{ route('admin.members.index') }}">
        <span class="ic">👥</span>
        Miembros
    </a>

    <a href="{{ route('admin.matches.index') }}">
        <span class="ic">🔗</span>
        Vinculación
    </a>

</aside>

<main class="main">

    <div class="ph">

        <div>
            <h1>Panel principal</h1>

            <p>
                Resumen general de actividad y participación del equipo
            </p>
        </div>

    </div>

    @if(session('success'))
        <div class="alerta alerta-exito">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- MÉTRICAS --}}

    <div class="grid-m">

        <div class="met">
            <div class="met-ico">👥</div>
            <div class="met-val az">{{ $summary['total_members'] }}</div>
            <div class="met-lbl">Miembros vinculados</div>
        </div>

        <div class="met">
            <div class="met-ico">📈</div>
            <div class="met-val vd">{{ $summary['participation_rate'] }}%</div>
            <div class="met-lbl">Participación</div>
        </div>

        <div class="met">
            <div class="met-ico">✅</div>
            <div class="met-val vd">{{ $summary['members_interacted'] }}</div>
            <div class="met-lbl">Interactuaron</div>
        </div>

        <div class="met">
            <div class="met-ico">😶</div>
            <div class="met-val rd">{{ $summary['members_silent'] }}</div>
            <div class="met-lbl">Sin interacción</div>
        </div>

        <div class="met">
            <div class="met-ico">📌</div>
            <div class="met-val az">{{ $summary['total_posts_tracked'] }}</div>
            <div class="met-lbl">Publicaciones</div>
        </div>

        <div class="met">
            <div class="met-ico">❤️</div>
            <div class="met-val az">{{ $summary['total_team_reactions'] }}</div>
            <div class="met-lbl">Reacciones</div>
        </div>

    </div>

    <div class="g2">

        {{-- PUBLICACIONES --}}

        <div class="card">

            <h3>📌 Publicaciones con más apoyo</h3>

            <div class="leyenda">

                <div class="leyenda-item">
                    <div class="leyenda-dot dot-fb"></div>
                    Facebook
                </div>

                <div class="leyenda-item">
                    <div class="leyenda-dot dot-team"></div>
                    Equipo
                </div>

            </div>

            <table>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Publicación</th>
                        <th>👍</th>
                        <th>💬</th>
                        <th>👥</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($topPosts as $i => $item)

                    <tr>

                        <td>
                            <span class="rank-num {{ $i === 0 ? 'top' : '' }}">
                                {{ $i + 1 }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('posts.detail', $item['post']->id) }}">
                                {{ Str::limit($item['post']->message ?? $item['post']->story ?? 'Sin texto', 45) }}
                            </a>
                        </td>

                        <td>
                            <span class="num-fb">
                                {{ $item['total_reactions'] }}
                            </span>
                        </td>

                        <td>
                            <span class="num-fb">
                                {{ $item['total_comments'] }}
                            </span>
                        </td>

                        <td>
                            <span class="num-team">
                                {{ $item['member_reactions'] + $item['member_comments'] }}
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="vacio">
                            Sin publicaciones aún
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        {{-- ESTRUCTURAS --}}

        <div class="card">

            <h3>🏛️ Estructuras más activas</h3>

            <table>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estructura</th>
                        <th>Miembros</th>
                        <th>Interacciones</th>
                        <th>Promedio</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($structureRanking as $i => $item)

                    <tr>

                        <td>
                            <span class="rank-num {{ $i === 0 ? 'top' : '' }}">
                                {{ $i + 1 }}
                            </span>
                        </td>

                        <td>{{ $item['structure']->name }}</td>

                        <td>{{ $item['total_members'] }}</td>

                        <td>
                            <strong>
                                {{ $item['total_interactions'] }}
                            </strong>
                        </td>

                        <td style="color:var(--gris-texto)">
                            {{ $item['avg_per_member'] }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="vacio">
                            Sin datos aún
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <br>

    {{-- SINCRONIZACIÓN --}}

    <div class="card">

        <h3>🔄 Sincronización manual</h3>

        <p style="color:var(--gris-texto);margin-bottom:20px;">
            Ejecuta procesos manuales de sincronización con Facebook.
        </p>

        <div class="sync-grid">

            <form method="POST" action="{{ route('admin.sync.posts') }}">
                @csrf
                <button class="btn-sync">
                    📥 Sincronizar publicaciones
                </button>
            </form>

            <form method="POST" action="{{ route('admin.sync.reactions') }}">
                @csrf
                <button class="btn-sync">
                    👍 Sincronizar reacciones
                </button>
            </form>

            <form method="POST" action="{{ route('admin.sync.comments') }}">
                @csrf
                <button class="btn-sync">
                    💬 Sincronizar comentarios
                </button>
            </form>

            <form method="POST" action="{{ route('admin.sync.match') }}">
                @csrf
                <button class="btn-sync">
                    🔗 Ejecutar vinculación
                </button>
            </form>

        </div>

    </div>

</main>

</body>
</html>