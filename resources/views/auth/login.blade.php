<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - Laravel CRUD Builder</title>
    <meta name="description" content="Login to the Laravel CRUD Builder - the ultimate tool for automated CRUD operations with flexible customization options.">
    <meta name="keywords" content="Laravel, CRUD, Builder, Login, Authentication, Admin, Automated, Database">
    <meta name="robots" content="index, follow">
    
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        /* Full-screen gradient background */
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #0d6efd, #6c757d);
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
        }
        .logo {
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            text-align: center;
            display: block;
            margin-bottom: 1.5rem;
        }
        .logo:hover {
            text-decoration: none;
            color: #d1e9ff;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .card-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
        /* Enhanced input fields */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-control {
            padding-left: 2.5rem;
            border-radius: 10px;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }
        /* Input icon positioning */
        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #555;
        }
        /* Button styling */
        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 10px;
            transition: background 0.3s ease;
            width: 100%;
            padding: 0.75rem;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #6610f2, #0d6efd);
        }
        /* SEO Optimization and Accessibility */
        .back-to-top {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="index.html" class="logo">Laravel CRUD Builder</a>
        <div class="card">
            <h5 class="card-title">Login to Your Account</h5>
            <p class="text-center small mb-4">Enter your email & password to login</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div class="form-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <label for="email" class="visually-hidden">Email</label>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <i class="bi bi-lock input-icon"></i>
                    <label for="password" class="visually-hidden">Password</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary">Log in</button>

                <div class="d-flex justify-content-between mt-3">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none" href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
</html>
