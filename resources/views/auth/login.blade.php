<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kasir Ende</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <main class="login-shell">
        <div class="login-logo" aria-hidden="true">
            <svg viewBox="0 0 24 24" role="img">
                <path d="M7 3.5h10a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2Z" fill="none" stroke="currentColor" stroke-width="1.8"/>
                <path d="M8 7h8M8 10.5h8M8 14h8M8 17.5h8" fill="none" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="10" cy="14" r=".8" fill="currentColor"/>
            </svg>
        </div>

        <section class="login-card" aria-label="Formulir login">
            @if ($errors->any())
                <div class="login-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
                <div class="field-group">
                    <label for="email">EMAIL</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3.5" fill="none" stroke="currentColor" stroke-width="2"/>
                                <circle cx="12" cy="12" r="1" fill="currentColor"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                    </div>
                </div>

                <div class="field-group">
                    <label for="password">PASSWORD</label>
                    <div class="input-wrap">
                        <input id="password" type="password" name="password" value="" autocomplete="current-password" required>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    MASUK
                    <span aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M10 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h4M14 8l4 4-4 4M8 12h10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </button>
            </form>
        </section>
    </main>
</body>
</html>
