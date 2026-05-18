<x-guest-layout>
    <style>
        .pc-login-page {
            min-height: 100vh;
            background: #f8fafc;
            color: #0f172a;
        }

        .pc-login-grid {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
        }

        .pc-hero {
            position: relative;
            overflow: hidden;
            color: #fff;
            background: #064e3b;
        }

        .pc-hero-image,
        .pc-hero-overlay {
            position: absolute;
            inset: 0;
        }

        .pc-hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.42;
        }

        .pc-hero-overlay {
            background: linear-gradient(135deg, rgba(2, 44, 34, 0.98), rgba(6, 78, 59, 0.9), rgba(8, 47, 73, 0.82));
        }

        .pc-hero-content {
            position: relative;
            min-height: 100vh;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .pc-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .pc-logo {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: #fff;
            color: #047857;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.18);
        }

        .pc-logo--small {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            background: #059669;
            color: #fff;
        }

        .pc-icon {
            width: 26px;
            height: 26px;
            display: block;
            flex-shrink: 0;
        }

        .pc-input-icon {
            width: 20px;
            height: 20px;
            display: block;
        }

        .pc-brand-title {
            margin: 0;
            font-size: 24px;
            line-height: 1;
            font-weight: 800;
        }

        .pc-brand-subtitle {
            margin: 4px 0 0;
            font-size: 14px;
            color: #d1fae5;
        }

        .pc-hero-copy {
            max-width: 600px;
            padding-bottom: 40px;
        }

        .pc-eyebrow {
            margin: 0 0 16px;
            color: #a7f3d0;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.26em;
            text-transform: uppercase;
        }

        .pc-hero-title {
            margin: 0;
            font-size: 48px;
            line-height: 1.12;
            font-weight: 850;
        }

        .pc-hero-text {
            margin: 24px 0 0;
            max-width: 540px;
            color: #ecfdf5;
            font-size: 18px;
            line-height: 1.7;
        }

        .pc-form-section {
            min-height: 100vh;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pc-form-wrap {
            width: 100%;
            max-width: 448px;
        }

        .pc-mobile-brand {
            display: none;
            margin-bottom: 32px;
            align-items: center;
            gap: 12px;
        }

        .pc-mobile-brand .pc-brand-title {
            font-size: 22px;
            color: #111827;
        }

        .pc-mobile-brand .pc-brand-subtitle {
            color: #64748b;
        }

        .pc-card {
            border: 1px solid #e5e7eb;
            border-radius: 22px;
            background: #fff;
            padding: 32px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }

        .pc-card-kicker {
            margin: 0;
            color: #059669;
            font-size: 13px;
            font-weight: 850;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .pc-card-title {
            margin: 8px 0 0;
            color: #020617;
            font-size: 32px;
            line-height: 1.15;
            font-weight: 850;
        }

        .pc-card-text {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .pc-errors {
            margin: 22px 0 0;
        }

        .pc-status {
            margin: 22px 0 0;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            background: #f0fdf4;
            padding: 12px 14px;
            color: #15803d;
            font-size: 14px;
            font-weight: 700;
        }

        .pc-form {
            margin-top: 30px;
            display: grid;
            gap: 20px;
        }

        .pc-field label,
        .pc-field [for] {
            color: #334155;
            font-size: 14px;
            font-weight: 700;
        }

        .pc-input-wrap {
            position: relative;
            margin-top: 6px;
        }

        .pc-input-wrap > span {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            pointer-events: none;
        }

        .pc-input {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            padding: 12px 14px 12px 44px;
            color: #0f172a;
            background: #fff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .pc-input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.16);
        }

        .pc-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .pc-remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 14px;
        }

        .pc-link {
            color: #047857;
            font-size: 14px;
            font-weight: 750;
            text-decoration: none;
        }

        .pc-link:hover {
            color: #065f46;
            text-decoration: underline;
        }

        .pc-submit {
            width: 100%;
            border: 0;
            border-radius: 14px;
            background: #059669;
            color: #fff;
            padding: 13px 18px;
            font-size: 15px;
            font-weight: 850;
            cursor: pointer;
            box-shadow: 0 16px 30px rgba(5, 150, 105, 0.24);
            transition: background 0.15s ease, transform 0.15s ease;
        }

        .pc-submit:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        @media (max-width: 1023px) {
            .pc-login-grid {
                display: block;
            }

            .pc-hero {
                display: none;
            }

            .pc-form-section {
                padding: 32px 20px;
            }

            .pc-mobile-brand {
                display: flex;
            }
        }

        @media (max-width: 520px) {
            .pc-card {
                padding: 24px;
            }

            .pc-card-title {
                font-size: 28px;
            }
        }
    </style>

    <div class="pc-login-page">
        <div class="pc-login-grid">
            <section class="pc-hero">
                <img src="{{ asset('images/logoveterinaria.jpg') }}" alt="PuppyCare" class="pc-hero-image">
                <div class="pc-hero-overlay"></div>

                <div class="pc-hero-content">
                    <div class="pc-brand">
                        <div class="pc-logo">
                            <svg class="pc-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8.25 10.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5ZM15.75 10.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5ZM5.75 15.25a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM18.25 15.25a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM12 11.5c-2.65 0-5 2.15-5 4.55 0 1.55 1.18 2.7 2.75 2.7.78 0 1.35-.25 1.8-.45.2-.08.32-.13.45-.13s.25.05.45.13c.45.2 1.02.45 1.8.45 1.57 0 2.75-1.15 2.75-2.7 0-2.4-2.35-4.55-5-4.55Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="pc-brand-title">PuppyCare</p>
                            <p class="pc-brand-subtitle">Sistema veterinario</p>
                        </div>
                    </div>

                    <div class="pc-hero-copy">
                        <p class="pc-eyebrow">Cuidado organizado</p>
                        <h1 class="pc-hero-title">Agenda, expedientes y consultas en un solo lugar.</h1>
                        <p class="pc-hero-text">
                            Accede al panel administrativo para gestionar dueños, mascotas, veterinarios, horarios y citas clínicas.
                        </p>
                    </div>
                </div>
            </section>

            <section class="pc-form-section">
                <div class="pc-form-wrap">
                    <div class="pc-mobile-brand">
                        <div class="pc-logo pc-logo--small">
                            <svg class="pc-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8.25 10.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5ZM15.75 10.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5ZM5.75 15.25a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM18.25 15.25a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM12 11.5c-2.65 0-5 2.15-5 4.55 0 1.55 1.18 2.7 2.75 2.7.78 0 1.35-.25 1.8-.45.2-.08.32-.13.45-.13s.25.05.45.13c.45.2 1.02.45 1.8.45 1.57 0 2.75-1.15 2.75-2.7 0-2.4-2.35-4.55-5-4.55Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="pc-brand-title">PuppyCare</p>
                            <p class="pc-brand-subtitle">Sistema veterinario</p>
                        </div>
                    </div>

                    <div class="pc-card">
                        <div>
                            <p class="pc-card-kicker">Bienvenido</p>
                            <h2 class="pc-card-title">Iniciar sesión</h2>
                            <p class="pc-card-text">Ingresa con el correo y contraseña asignados.</p>
                        </div>

                        <div class="pc-errors">
                            <x-validation-errors />
                        </div>

                        @session('status')
                            <div class="pc-status">
                                {{ $value }}
                            </div>
                        @endsession

                        <form method="POST" action="{{ route('login') }}" class="pc-form">
                            @csrf

                            <div class="pc-field">
                                <x-label for="email" value="Correo electrónico" />
                                <div class="pc-input-wrap">
                                    <span>
                                        <svg class="pc-input-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 7.5v9a2.25 2.25 0 0 1-2.25 2.25h-15A2.25 2.25 0 0 1 2.25 16.5v-9m19.5 0A2.25 2.25 0 0 0 19.5 5.25h-15A2.25 2.25 0 0 0 2.25 7.5m19.5 0-8.27 5.51a2.25 2.25 0 0 1-2.5 0L2.25 7.5" />
                                        </svg>
                                    </span>
                                    <input id="email" class="pc-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                </div>
                            </div>

                            <div class="pc-field">
                                <x-label for="password" value="Contraseña" />
                                <div class="pc-input-wrap">
                                    <span>
                                        <svg class="pc-input-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5 0 0 0-9 0v3m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v6.75a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                        </svg>
                                    </span>
                                    <input id="password" class="pc-input" type="password" name="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="pc-options">
                                <label for="remember_me" class="pc-remember">
                                    <x-checkbox id="remember_me" name="remember" />
                                    <span>Recordarme</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="pc-link" href="{{ route('password.request') }}">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="pc-submit">
                                Entrar al panel
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
