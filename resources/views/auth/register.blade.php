<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Register - Helpdesk IT</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

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
        }

        * { box-sizing: border-box; }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 15px;
            min-height: 100vh;
        }

        h1, h2, h3 { font-weight: 700; letter-spacing: -0.01em; color: var(--ink); }
        .text-muted { color: var(--ink-faint) !important; }

        .auth-wrap {
            min-height: 100vh;
            display: flex;
        }

        .auth-card {
            width: 100%;
            display: flex;
            background: var(--surface);
        }

        /* LEFT: VISUAL PANEL */
        .auth-visual {
            flex: 1 1 60%;
            position: relative;
            min-height: 100vh;
            background:
                linear-gradient(180deg, rgba(13,27,54,0) 0%, rgba(13,27,54,0.15) 42%, rgba(13,27,54,0.78) 62%, rgba(13,27,54,0.97) 80%, #0D1B36 100%),
                url('{{ asset('images/kantorkelurahan.jpg') }}') center / cover no-repeat;
        }

        .auth-visual-text {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 2.5rem 3rem 3.2rem;
            color: #fff;
        }
        .auth-visual-text h2 {
            color: #fff;
            font-size: 2.5rem;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }
        .auth-visual-text .auth-visual-sub {
            font-size: 1.2rem;
            font-weight: 600;
            color: #BFD0FF;
            margin-bottom: 1.4rem;
        }
        .auth-visual-text .auth-visual-desc {
            font-size: 1.02rem;
            color: rgba(255,255,255,0.75);
            max-width: 420px;
            line-height: 1.55;
        }

        /* RIGHT: FORM PANEL */
        .auth-form-panel {
            flex: 1 1 40%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2.5rem;
        }
        .auth-form-inner { width: 100%; max-width: 380px; }

        .auth-form-inner h1 {
            font-size: 1.55rem;
            margin-bottom: 0.3rem;
        }
        .auth-form-inner .auth-form-sub {
            font-size: 0.92rem;
            color: var(--ink-faint);
            margin-bottom: 1.3rem;
        }

        .input-icon-group {
            position: relative;
            margin-bottom: 0.8rem;
        }
        .input-icon-group .field-icon {
            position: absolute;
            left: 0.95rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-faint);
            display: flex;
            width: 18px;
            height: 18px;
            pointer-events: none;
        }
        .input-icon-group .field-icon svg { width: 100%; height: 100%; }
        .input-icon-group .form-control {
            padding-left: 2.6rem;
        }

        .form-control {
            border-color: var(--border);
            border-radius: 10px;
            font-size: 0.93rem;
            padding: 0.68rem 1rem;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }
        .form-control::placeholder { color: var(--ink-faint); }

        .btn { border-radius: 10px; font-weight: 600; font-size: 0.93rem; padding: 0.75rem 1rem; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #2249C4; border-color: #2249C4; }

                .alert-danger {
            background: #FDECEC;
            color: #B42318;
            border: 1px solid #F8D2D2;
            border-radius: 10px;
            font-size: 0.85rem;
            padding: 0.65rem 0.9rem;
            margin-bottom: 1rem;
        }
        .alert-danger ul { padding-left: 1.1rem; }

        .auth-footer-link {
            text-align: center;
            font-size: 0.88rem;
            color: var(--ink-soft);
            margin-top: 1.1rem;
        }
        .auth-footer-link a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer-link a:hover { text-decoration: underline; }

        /* TABLET */
        @media (max-width: 991px) {
            .auth-visual { flex-basis: 50%; }
            .auth-form-panel { flex-basis: 50%; padding: 2rem 1.75rem; }
            .auth-visual-text { padding: 2rem 1.75rem 2.25rem; }
            .auth-visual-text h2 { font-size: 1.9rem; }
            .auth-visual-text .auth-visual-sub { font-size: 1rem; }
            .auth-visual-text .auth-visual-desc { font-size: 0.9rem; }
        }

        /* HP */
        @media (max-width: 767px) {
            .auth-card { flex-direction: column; }
            .auth-visual { min-height: 260px; flex: none; }
            .auth-visual-text { padding: 1.5rem 1.5rem 1.6rem; }
            .auth-visual-text h2 { font-size: 1.5rem; }
            .auth-visual-text .auth-visual-sub { font-size: 0.92rem; margin-bottom: 0.6rem; }
            .auth-visual-text .auth-visual-desc { font-size: 0.85rem; }

            .auth-form-panel { flex: none; padding: 1.75rem 1.5rem 2.25rem; align-items: flex-start; }
            .auth-form-inner { max-width: 100%; }
            .auth-form-inner h1 { font-size: 1.45rem; }
            .auth-form-inner .auth-form-sub { font-size: 0.88rem; margin-bottom: 1.25rem; }
            .form-control { font-size: 16px; } /* cegah auto-zoom di iOS */
            .auth-footer-link { font-size: 0.85rem; }
        }

    </style>

</head>

<body>

<div class="auth-wrap">

    <div class="auth-card">

        <!-- ================================================= -->
        <!-- VISUAL PANEL -->
        <!-- ================================================= -->

        <div class="auth-visual">

            <div class="auth-visual-text">

                <h2>SIPENDAK</h2>

                <div class="auth-visual-sub">
                    Sistem Pengaduan & Penanganan Perangkat Rusak
                </div>

                <div class="auth-visual-desc">
                    Daftar sebagai staf untuk mulai
                    melaporkan kerusakan perangkat.
                </div>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- FORM PANEL -->
        <!-- ================================================= -->

        <div class="auth-form-panel">

            <div class="auth-form-inner">

                <h1>Daftar Akun</h1>

                <p class="auth-form-sub">
                    Akun yang dibuat otomatis menjadi staf.
                </p>

                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form
                    method="POST"
                    action="{{ route('register.store') }}"
                >

                    @csrf

                    <div class="input-icon-group">

                        <span class="field-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20c0-4 3.6-6 8-6s8 2 8 6"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkap"
                            required
                        >

                    </div>

                    <div class="input-icon-group">

                        <span class="field-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                        </span>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="Email"
                            required
                        >

                    </div>

                    <div class="input-icon-group">

                        <span class="field-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>
                        </span>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Password"
                            required
                        >

                    </div>

                    <div class="input-icon-group mb-4">

                        <span class="field-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>
                        </span>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Konfirmasi password"
                            required
                        >

                    </div>

                    <button
                        class="btn btn-primary w-100"
                    >
                        Daftar
                    </button>

                </form>

                <div class="auth-footer-link">

                    <a href="{{ route('login') }}">
                        Kembali ke Login
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>