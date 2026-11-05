<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sedes') · Forja Gym TP10</title>
    <style>
        :root {
            --bg: #080808;
            --surface: #111;
            --card: #161616;
            --border: #2a2a2a;
            --text: #f2f2f2;
            --muted: #888;
            --acid: #c8ff00;
            --danger: #ff6b6b;
            --ok: #7dff9b;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            line-height: 1.6;
        }
        a { color: inherit; }
        .container { width: min(1080px, 92%); margin: 0 auto; }
        .topbar { border-bottom: 1px solid var(--border); background: rgba(8, 8, 8, 0.96); }
        .topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1rem 0;
        }
        .brand { font-weight: 900; font-size: 1.4rem; letter-spacing: 0.04em; text-decoration: none; }
        .brand span { color: var(--acid); }
        .tag {
            color: var(--muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
        }
        nav { display: flex; gap: 1rem; flex-wrap: wrap; }
        nav a { text-decoration: none; color: var(--muted); font-weight: 600; }
        nav a:hover { color: var(--acid); }
        .main { padding: 2.5rem 0 4rem; }
        .page-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .kicker { color: var(--acid); text-transform: uppercase; letter-spacing: 0.18em; font-size: 0.8rem; font-weight: 700; }
        h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); line-height: 1.05; margin: 0.4rem 0 0; }
        h2 { margin-top: 0; }
        .btn {
            display: inline-block;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.6rem 1rem;
            background: var(--card);
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            font-family: inherit;
        }
        .btn:hover { border-color: var(--acid); color: var(--acid); }
        .btn.primary { background: var(--acid); border-color: var(--acid); color: #080808; }
        .btn.primary:hover { background: #b5e800; color: #080808; }
        .btn.ghost { background: transparent; }
        .btn.danger { border-color: var(--danger); color: var(--danger); background: transparent; }
        .btn.danger:hover { background: rgba(255, 107, 107, 0.12); }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 1.4rem; }
        .muted { color: var(--muted); }
        .small { font-size: 0.85rem; }
        .alert { border-radius: 10px; padding: 0.85rem 1rem; margin-bottom: 1.2rem; border: 1px solid var(--border); }
        .alert.success { border-color: var(--ok); background: rgba(125, 255, 155, 0.08); }
        .alert.error { border-color: var(--danger); background: rgba(255, 107, 107, 0.08); }
        .table-wrap { overflow-x: auto; border: 1px solid var(--border); border-radius: 14px; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { text-align: left; padding: 0.85rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        th { color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: rgba(200, 255, 0, 0.03); }
        .actions { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
        .actions form { margin: 0; }
        .form { display: grid; gap: 1.1rem; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .field { display: grid; gap: 0.35rem; }
        .field.full { grid-column: 1 / -1; }
        label { font-weight: 700; }
        input {
            width: 100%;
            background: #0c0c0c;
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 10px;
            padding: 0.7rem 0.8rem;
            font: inherit;
        }
        input:focus-visible { outline: 2px solid var(--acid); outline-offset: 2px; }
        .error-text { color: var(--danger); font-size: 0.85rem; }
        .form-actions { display: flex; gap: 0.8rem; flex-wrap: wrap; margin-top: 0.5rem; }
        .detail { display: grid; gap: 1rem; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .detail .full { grid-column: 1 / -1; }
        .detail dt { color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.2rem; }
        .detail dd { margin: 0; font-weight: 600; }
        .footer { border-top: 1px solid var(--border); padding: 1.4rem 0; color: var(--muted); font-size: 0.85rem; }
        @media (max-width: 640px) {
            .grid, .detail { grid-template-columns: 1fr; }
            .page-head { align-items: flex-start; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a class="brand" href="{{ route('sedes.index') }}">FORJA<span>.</span></a>
            <span class="tag">TP10 · Laravel · Módulo Sedes</span>
            <nav aria-label="Navegación del módulo">
                <a href="{{ route('sedes.index') }}">Sedes</a>
                <a href="{{ route('sedes.create') }}">Nueva sede</a>
            </nav>
        </div>
    </header>

    <main class="container main">
        <div class="page-head">
            <div>
                <span class="kicker">Framework Laravel</span>
                <h1>@yield('heading', 'Sedes')</h1>
            </div>
            <div>@yield('actions')</div>
        </div>

        @if (session('success'))
            <div class="alert success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error" role="alert">Revisá los datos: {{ $errors->count() }} error(es).</div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            Forja Gym · Trabajo Práctico 10 · Laravel {{ app()->version() }} con Eloquent y Blade.
        </div>
    </footer>
</body>
</html>
