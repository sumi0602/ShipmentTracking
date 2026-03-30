<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Real-time shipment tracking system" />
    <title>@yield('title', 'Shipments') — TrackFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet" />

    <style>
        /* ── Reset & Base ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:       #0a0a0f;
            --ink-2:     #1c1c2e;
            --ink-3:     #3a3a52;
            --muted:     #7c7c9a;
            --line:      #e4e4f0;
            --line-2:    #f0f0fa;
            --surface:   #fafafa;
            --white:     #ffffff;

            --accent:    #2d1cf7;
            --accent-2:  #5a46ff;
            --accent-bg: #ede9ff;

            --green:     #00875a;
            --green-bg:  #e3fcef;
            --amber:     #b45309;
            --amber-bg:  #fffbeb;
            --blue:      #1d4ed8;
            --blue-bg:   #eff6ff;

            --radius:    10px;
            --radius-lg: 16px;
            --shadow:    0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
            --shadow-md: 0 2px 8px rgba(0,0,0,.08), 0 8px 32px rgba(0,0,0,.06);

            --font-sans: 'DM Sans', system-ui, sans-serif;
            --font-display: 'Syne', sans-serif;
            --font-mono: 'DM Mono', monospace;
        }

        html { font-size: 16px; -webkit-text-size-adjust: 100%; }

        body {
            font-family: var(--font-sans);
            background: var(--surface);
            color: var(--ink);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ── Nav ────────────────────────────────────────────────────── */
        .nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--line);
        }

        .nav__inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav__logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--ink);
            text-decoration: none;
            letter-spacing: -.02em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav__logo-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent);
        }

        .nav__link {
            font-size: .875rem;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: color .15s;
        }

        .nav__link:hover { color: var(--ink); }

        /* ── Page Container ─────────────────────────────────────────── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* ── Page Header ────────────────────────────────────────────── */
        .page-header {
            margin-bottom: 32px;
        }

        .page-header__eyebrow {
            font-family: var(--font-mono);
            font-size: .75rem;
            font-weight: 500;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 6px;
        }

        .page-header__title {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1.1;
            color: var(--ink);
        }

        .page-header__sub {
            margin-top: 8px;
            font-size: .9375rem;
            color: var(--muted);
        }

        /* ── Card ───────────────────────────────────────────────────── */
        .card {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        /* ── Badge ──────────────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .01em;
            white-space: nowrap;
        }

        .badge--pending    { background: var(--amber-bg); color: var(--amber); }
        .badge--transit    { background: var(--blue-bg);  color: var(--blue); }
        .badge--delivered  { background: var(--green-bg); color: var(--green); }

        .badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        /* ── Button ─────────────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: var(--radius);
            font-family: var(--font-sans);
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
            border: none;
            white-space: nowrap;
        }

        .btn--primary {
            background: var(--accent);
            color: #fff;
        }

        .btn--primary:hover { background: var(--accent-2); transform: translateY(-1px); }

        .btn--ghost {
            background: transparent;
            color: var(--ink-3);
            border: 1px solid var(--line);
        }

        .btn--ghost:hover { background: var(--line-2); color: var(--ink); }

        /* ── Search ─────────────────────────────────────────────────── */
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }

        .search-input {
            flex: 1;
            max-width: 360px;
            padding: 9px 14px;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            font-family: var(--font-sans);
            font-size: .9375rem;
            color: var(--ink);
            background: var(--white);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }

        .search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-bg);
        }

        .search-input::placeholder { color: var(--muted); }

        /* ── Table ──────────────────────────────────────────────────── */
        .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9375rem;
        }

        thead th {
            padding: 12px 20px;
            text-align: left;
            font-family: var(--font-mono);
            font-size: .7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--line-2);
            transition: background .1s;
        }

        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--surface); }

        tbody td {
            padding: 16px 20px;
            vertical-align: middle;
        }

        .td-track {
            font-family: var(--font-mono);
            font-size: .8125rem;
            font-weight: 500;
            color: var(--accent);
        }

        .td-name { font-weight: 500; color: var(--ink); }
        .td-city { color: var(--ink-3); }
        .td-date { font-size: .875rem; color: var(--muted); white-space: nowrap; }

        .row-link {
            text-decoration: none;
            color: inherit;
            display: contents;
        }

        /* ── Pagination ─────────────────────────────────────────────── */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-top: 1px solid var(--line);
            font-size: .875rem;
            color: var(--muted);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination__links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination__links a,
        .pagination__links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border-radius: 8px;
            font-size: .875rem;
            text-decoration: none;
            color: var(--ink-3);
            border: 1px solid var(--line);
            background: var(--white);
            transition: all .15s;
        }

        .pagination__links a:hover {
            background: var(--line-2);
            color: var(--ink);
            border-color: var(--ink-3);
        }

        .pagination__links .active span,
        .pagination__links span[aria-current="page"] span {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .pagination__links span[aria-disabled="true"],
        .pagination__links .disabled span {
            opacity: .4;
            cursor: not-allowed;
        }

        /* ── Empty State ────────────────────────────────────────────── */
        .empty {
            padding: 72px 24px;
            text-align: center;
        }

        .empty__icon {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: .25;
        }

        .empty__title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--ink-3);
            margin-bottom: 6px;
        }

        .empty__text { font-size: .9375rem; color: var(--muted); }

        /* ── Stat Cards ─────────────────────────────────────────────── */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .stat__label {
            font-family: var(--font-mono);
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .stat__value {
            font-family: var(--font-display);
            font-size: 1.875rem;
            font-weight: 800;
            letter-spacing: -.03em;
            color: var(--ink);
            line-height: 1;
        }

        /* ── Detail Grid ────────────────────────────────────────────── */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        @media (max-width: 640px) {
            .detail-grid { grid-template-columns: 1fr; }
        }

        .detail-section {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .detail-section__title {
            font-family: var(--font-mono);
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--muted);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-bottom: 14px;
        }

        .detail-row:last-child { margin-bottom: 0; }

        .detail-row__label {
            font-size: .75rem;
            color: var(--muted);
            font-weight: 500;
        }

        .detail-row__value {
            font-size: .9375rem;
            color: var(--ink);
            font-weight: 500;
        }

        /* ── Timeline ───────────────────────────────────────────────── */
        .timeline {
            position: relative;
            padding: 28px;
        }

        .timeline__track {
            position: absolute;
            left: 52px;
            top: 28px;
            bottom: 28px;
            width: 2px;
            background: var(--line);
        }

        .timeline__item {
            display: flex;
            gap: 20px;
            padding-bottom: 28px;
            position: relative;
        }

        .timeline__item:last-child { padding-bottom: 0; }

        .timeline__dot {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .875rem;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 2px var(--line);
        }

        .timeline__dot--pending  { background: var(--amber-bg); color: var(--amber); }
        .timeline__dot--transit  { background: var(--blue-bg);  color: var(--blue); }
        .timeline__dot--delivered{ background: var(--green-bg); color: var(--green); }

        .timeline__content {
            flex: 1;
            padding-top: 4px;
        }

        .timeline__header {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 4px;
        }

        .timeline__status {
            font-weight: 600;
            font-size: .9375rem;
            color: var(--ink);
        }

        .timeline__location {
            font-size: .875rem;
            color: var(--muted);
        }

        .timeline__note {
            font-size: .875rem;
            color: var(--ink-3);
            margin-top: 4px;
        }

        .timeline__time {
            font-family: var(--font-mono);
            font-size: .75rem;
            color: var(--muted);
        }

        /* ── Back link ──────────────────────────────────────────────── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .875rem;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 24px;
            transition: color .15s;
        }

        .back-link:hover { color: var(--ink); }

        /* ── Flash ──────────────────────────────────────────────────── */
        .flash {
            max-width: 1200px;
            margin: 16px auto 0;
            padding: 0 24px;
        }

        .flash__msg {
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: .9375rem;
            background: var(--green-bg);
            color: var(--green);
            border: 1px solid #b7ebd5;
        }

        /* ── Responsive ─────────────────────────────────────────────── */
        @media (max-width: 768px) {
            .container { padding: 24px 16px 60px; }
            .search-form { flex-direction: column; }
            .search-input { max-width: 100%; }
            thead th:nth-child(3),
            tbody td:nth-child(3) { display: none; }
        }
    </style>
</head>
<body>

    {{-- Navigation --}}
    <nav class="nav">
        <div class="nav__inner">
            <a href="{{ route('shipments.index') }}" class="nav__logo">
                <span class="nav__logo-dot"></span>
                TrackFlow
            </a>
            <a href="{{ route('shipments.index') }}" class="nav__link">All Shipments</a>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash">
            <p class="flash__msg">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Page Content --}}
    @yield('content')

</body>
</html>
