<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f8;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
        }

        .login-box {
            width: 350px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 6px;
            background: #222;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #000;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Login</h2>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.store') }}" method="POST">

        @csrf

        <div class="input-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="input-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>