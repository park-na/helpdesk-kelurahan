<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Dashboard Staf - Helpdesk IT
    </title>

<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        :root {
            --ink: #172033;
            --ink-soft: #4B5568;
            --ink-faint: #8891A3;
            --bg: #F3F5F9;
            --surface: #FFFFFF;
            --border: #E2E6EE;
            --accent: #2C5CE0;
            --accent-soft: #EAF0FE;
            --amber: #B45309;
            --amber-soft: #FDF1E1;
            --amber-dot: #F59E0B;
            --teal: #0F8F6C;
            --teal-soft: #E5F6F1;
            --radius: 10px;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 15px;
        }

        h2, h5, h6 { font-weight: 650; letter-spacing: -0.01em; color: var(--ink); }
        .text-muted { color: var(--ink-faint) !important; }

        /* SHELL / SIDEBAR */
        .app-shell { display: flex; align-items: stretch; min-height: 100vh; }

        .sidebar {
            width: 232px;
            flex-shrink: 0;
            background: #101826;
            color: #C7CEDB;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            border-right: 1px solid #1E2A3D;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 1.35rem 1.25rem;
            border-bottom: 1px solid #1E2A3D;
        }
        .brand-mark {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            flex-shrink: 0;
        }
        .brand-title { font-size: 0.92rem; font-weight: 650; color: #F4F6FA; line-height: 1.2; }
        .brand-sub { font-size: 0.74rem; color: #7C879C; }

        .sidebar-nav { flex: 1; padding: 1rem 0.75rem; display: flex; flex-direction: column; gap: 0.2rem; }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.6rem 0.8rem;
            border-radius: 8px;
            color: #B4BDCC;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
        }
        .sidebar-nav .nav-link:hover { background: #182234; color: #F4F6FA; }
        .sidebar-nav .nav-link.active { background: rgba(44,92,224,0.22); color: #8FB0FF; }
        .sidebar-nav .nav-icon { display: flex; width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-nav .nav-icon svg { width: 100%; height: 100%; }

        .sidebar-footer {
            border-top: 1px solid #1E2A3D;
            padding: 0.9rem 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.6rem;
        }
        .sidebar-footer form { margin: 0; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: #F4F6FA; }
        .user-role { font-size: 0.74rem; color: #7C879C; }
        .btn-logout {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #263349;
            background: transparent;
            color: #9AA5B8;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-logout:hover { background: #182234; color: #fff; border-color: #182234; }
        .btn-logout svg { width: 16px; height: 16px; }

        .main-content { flex: 1; min-width: 0; }

        @media (max-width: 860px) {
            .app-shell { flex-direction: column; }
            .sidebar {
                width: 100%;
                height: auto;
                position: sticky;
                top: 0;
                z-index: 20;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
            .sidebar-brand { border-bottom: 0; padding: 0.75rem 1rem; }
            .sidebar-nav { flex-direction: row; padding: 0; margin-right: 0.5rem; }
            .sidebar-footer { border-top: 0; padding: 0.75rem 1rem; }
            .user-role { display: none; }
        }

        /* CARDS */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: none;
        }

        /* STAT CARDS */
        .stat-card {
            border-left: 3px solid var(--stat-color, var(--accent));
            padding: 0.35rem 0.2rem;
        }
        .stat-card .stat-label { font-size: 0.83rem; color: var(--ink-soft); font-weight: 600; }
        .stat-card .stat-num { font-size: 2.1rem; font-weight: 700; line-height: 1; margin: 0.4rem 0 0.3rem; color: var(--ink); }
        .stat-card .stat-sub { font-size: 0.78rem; color: var(--ink-faint); }

        /* STATUS PILLS */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .status-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }
        .status-waiting { background: var(--amber-soft); color: var(--amber); }
        .status-processing { background: var(--accent-soft); color: var(--accent); }
        .status-completed { background: var(--teal-soft); color: var(--teal); }

        /* TABLE */
        .table-clean thead th {
            font-size: 0.75rem;
            color: var(--ink-faint);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 0.9rem;
            white-space: nowrap;
        }
        .table-clean tbody td {
            padding: 0.85rem 0.9rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .table-clean tbody tr:last-child td { border-bottom: none; }
        .table-clean tbody tr:hover { background: var(--accent-soft); }
        .ticket-code {
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--ink);
        }

        /* BUTTONS */
        .btn { border-radius: 8px; font-weight: 600; font-size: 0.88rem; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #2249C4; border-color: #2249C4; }
        .btn-outline-primary { color: var(--accent); border-color: var(--accent); }
        .btn-outline-primary:hover { background: var(--accent); border-color: var(--accent); }
        .btn-secondary { background: var(--surface); border-color: var(--border); color: var(--ink-soft); }
        .btn-secondary:hover { background: var(--bg); color: var(--ink); border-color: var(--border); }
        .btn-sm { border-radius: 7px; }

        /* FORM */
        .form-control, .form-select {
            border-color: var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }
        .form-label { font-size: 0.85rem; font-weight: 600; color: var(--ink-soft); }
        .form-text { font-size: 0.8rem; color: var(--ink-faint); }

        /* ALERTS */
        .auto-alert {
            border-radius: 8px;
            border: 1px solid transparent;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .auto-alert.fade-out { opacity: 0; transform: translateY(-8px); }
        .alert-success { background: var(--teal-soft); color: var(--teal); border-color: #CFEEE3; }
        .alert-danger { background: #FDECEC; color: #B42318; border-color: #F8D2D2; }

        /* WORKFLOW STEPS (dashboard) */
        .flow-step {
            border-radius: var(--radius);
            padding: 1rem 1.1rem;
            text-align: left;
            border: 1px solid var(--border);
            border-top: 3px solid var(--step-color, var(--accent));
            height: 100%;
            background: var(--surface);
        }

        /* TIMELINE (show page) */
        .timeline-item {
            position: relative;
            border-left: 2px solid var(--border);
            padding-left: 1.1rem;
            padding-bottom: 1.5rem;
        }
        .timeline-item:last-child { border-left-color: transparent; padding-bottom: 0; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 2px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent);
        }

        /* DEFINITION LIST (show page info) */
        .info-list dt { color: var(--ink-faint); font-weight: 500; font-size: 0.83rem; }
        .info-list dd { color: var(--ink); font-weight: 500; margin-bottom: 0.9rem; }

    
        /* LATAR HANGAT (portal staf) */
        :root { --bg: #FAF7F3; --border: #ECE3D9; }
        .table-clean tbody tr:hover { background: #FFF6EE; }

        /* SIDEBAR PEACH (portal staf) */
        .sidebar { background: #FFF1E6; color: #6B4A36; border-right: 1px solid #F3D5BC; }
        .sidebar-brand { border-bottom: 1px solid #F3D5BC; }
        .sidebar .brand-mark { background: #EA7A1C; color: #fff; }
        .brand-title { color: #3F2716; }
        .brand-sub { color: #A0745A; }
        .sidebar-nav .nav-link { color: #7A5540; }
        .sidebar-nav .nav-link:hover { background: #FFE3CC; color: #3F2716; }
        .sidebar-nav .nav-link.active { background: #FFD9B8; color: #B34700; }
        .sidebar-footer { border-top: 1px solid #F3D5BC; }
        .user-name { color: #3F2716; }
        .user-role { color: #A0745A; }
        .btn-logout { border-color: #F0D3BC; color: #8A5A3C; }
        .btn-logout:hover { background: #FFE3CC; color: #3F2716; border-color: #FFE3CC; }

        /* STAF */
        .btn-dark { background: var(--ink); border-color: var(--ink); }
        .btn-dark:hover { background: #0F172A; border-color: #0F172A; }
        .btn-outline-danger { color: #B42318; border-color: #F0C4C4; background: transparent; }
        .btn-outline-danger:hover { background: #B42318; border-color: #B42318; color: #fff; }
        .form-control:disabled { background: var(--bg); color: var(--ink-faint); }
        .form-control[type="file"] { padding: 0.5rem 0.75rem; }
        .req { color: #B42318; }
        .opt { color: var(--ink-faint); font-weight: 500; }
        .note-box {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem;
            color: var(--ink-soft);
            white-space: pre-line;
        }

    </style>

</head>


<body>

<div class="app-shell">

    <!-- ========================================================= -->
    <!-- SIDEBAR -->
    <!-- ========================================================= -->

    <aside class="sidebar">

        <div class="sidebar-brand">
            <span class="brand-mark">IT</span>
            <div>
                <div class="brand-title">Helpdesk IT</div>
                <div class="brand-sub">Portal Staf</div>
            </div>
        </div>


        <nav class="sidebar-nav">

            <a
                href="{{ route('staff.tickets.index') }}"
                class="nav-link {{ request()->routeIs('staff.tickets.index', 'staff.tickets.show') ? 'active' : '' }}"
            >
                <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span>
                Dashboard
            </a>

            <a
                href="{{ route('staff.tickets.create') }}"
                class="nav-link {{ request()->routeIs('staff.tickets.create') ? 'active' : '' }}"
            >
                <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v8"/><path d="M8 12h8"/></svg></span>
                Buat Pengaduan
            </a>

            <a
                href="{{ route('staff.profile.edit') }}"
                class="nav-link {{ request()->routeIs('staff.profile.*') ? 'active' : '' }}"
            >
                <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6"/><circle cx="12" cy="7" r="4"/></svg></span>
                Profil Saya
            </a>

        </nav>


        <div class="sidebar-footer">

            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Staf</div>
            </div>

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit" class="btn-logout" title="Logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                </button>

            </form>

        </div>

    </aside>



    <!-- ========================================================= -->
    <!-- MAIN CONTENT -->
    <!-- ========================================================= -->

    <main class="main-content">

<div class="container-fluid px-4 px-lg-5 py-4" style="max-width:1200px;">

    @if(session('success'))

        <div class="alert alert-success auto-alert">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger auto-alert">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- HEADER -->

    <div class="mb-4">

        <h2 class="mb-1">
            Dashboard Staf
        </h2>

        <p class="text-muted mb-0">

            Selamat datang,
            <strong>
                {{ auth()->user()->name }}
            </strong>

        </p>

    </div>



    <!-- ===================================================== -->
    <!-- STATISTIK -->
    <!-- ===================================================== -->

    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">

            <div class="card stat-card h-100" style="--stat-color:#4B5568">

                <div class="card-body">

                    <div class="stat-label">
                        Total Pengaduan
                    </div>

                    <div class="stat-num">
                        {{ $counts['all'] }}
                    </div>

                    <div class="stat-sub">
                        Semua laporan Anda
                    </div>

                </div>

            </div>

        </div>


        <div class="col-6 col-md-3">

            <div class="card stat-card h-100" style="--stat-color:#F59E0B">

                <div class="card-body">

                    <div class="stat-label">
                        Menunggu Respons
                    </div>

                    <div class="stat-num" style="color:var(--amber)">
                        {{ $counts['waiting'] }}
                    </div>

                    <div class="stat-sub">
                        Belum ditangani
                    </div>

                </div>

            </div>

        </div>


        <div class="col-6 col-md-3">

            <div class="card stat-card h-100" style="--stat-color:#2C5CE0">

                <div class="card-body">

                    <div class="stat-label">
                        Sedang Diproses
                    </div>

                    <div class="stat-num" style="color:var(--accent)">
                        {{ $counts['processing'] }}
                    </div>

                    <div class="stat-sub">
                        Sedang ditangani teknisi
                    </div>

                </div>

            </div>

        </div>


        <div class="col-6 col-md-3">

            <div class="card stat-card h-100" style="--stat-color:#0F8F6C">

                <div class="card-body">

                    <div class="stat-label">
                        Selesai
                    </div>

                    <div class="stat-num" style="color:var(--teal)">
                        {{ $counts['completed'] }}
                    </div>

                    <div class="stat-sub">
                        Perbaikan selesai
                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- PENGADUAN SAYA -->
    <!-- ===================================================== -->

    <div class="card" id="pengaduan-saya">

        <div class="card-body p-4">


            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>

                    <h5 class="mb-1">
                        Pengaduan Saya
                    </h5>

                    <p class="text-muted mb-0">

                        Riwayat pengaduan perangkat
                        yang kamu buat.

                    </p>

                </div>


                @if($tickets->isNotEmpty())

                    <a
                        href="{{ route('staff.tickets.create') }}"
                        class="btn btn-outline-primary btn-sm"
                    >
                        Pengaduan Baru
                    </a>

                @endif

            </div>



            <div class="table-responsive">

                <table class="table table-hover align-middle table-clean mb-0">

                    <thead>

                    <tr>

                        <th>
                            No Tiket
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Perangkat
                        </th>

                        <th>
                            Ruangan
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    @forelse($tickets as $ticket)

                        <tr>

                            <td>
                                <span class="ticket-code">
                                    {{ $ticket->ticket_number }}
                                </span>
                            </td>


                            <td>
                                {{ $ticket->created_at->format('d/m/Y') }}
                            </td>


                            <td>

                                <strong>
                                    {{ $ticket->device_name }}
                                </strong>

                                <div class="small text-muted">
                                    {{ $ticket->device_type }}
                                </div>

                            </td>


                            <td>
                                {{ $ticket->room_name }}
                            </td>


                            <td>

                                @if($ticket->status === 'waiting')

                            <span class="status-pill status-waiting">
                                Menunggu Respons
                            </span>

                        @elseif($ticket->status === 'processing')

                            <span class="status-pill status-processing">
                                Sedang Diproses
                            </span>

                        @elseif($ticket->status === 'completed')

                            <span class="status-pill status-completed">
                                Selesai
                            </span>

                        @endif

                            </td>


                            <td>

                                <a
                                    href="{{ route('staff.tickets.show', $ticket) }}"
                                    class="btn btn-sm btn-primary"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <h6>
                                    Belum ada pengaduan
                                </h6>

                                <p class="text-muted">

                                    Kamu belum membuat
                                    laporan kerusakan perangkat.

                                </p>

                                <a
                                    href="{{ route('staff.tickets.create') }}"
                                    class="btn btn-primary"
                                >
                                    Buat Pengaduan
                                </a>

                            </td>

                        </tr>

                    @endforelse


                    </tbody>

                </table>

            </div>


            <div class="mt-3">
                {{ $tickets->links() }}
            </div>


        </div>

    </div>

</div>

    </main>

</div>

<script>
    setTimeout(function () {

        const alerts = document.querySelectorAll('.auto-alert');

        alerts.forEach(function (alert) {

            alert.classList.add('fade-out');

            setTimeout(function () {
                alert.remove();
            }, 500);

        });

    }, 3000);
</script>

</body>
</html>