<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kasir Ende</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div style="max-width: 400px; margin: 80px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
        <h2>Login Kasir Ende</h2>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div style="margin-bottom: 12px;">
                <label>Email</label><br>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label>Password</label><br>
                <input type="password" name="password" required style="width: 100%; padding: 8px;">
            </div>

            <button type="submit" style="width: 100%; padding: 10px; cursor: pointer;">Masuk</button>
        </form>
    </div>
</body>
</html>
