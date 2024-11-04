<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Builder - Power Up Your Projects</title>
    <meta name="description" content="Login to the Laravel CRUD Builder - the ultimate tool for automated CRUD operations with flexible customization options.">
    <meta name="keywords" content="Laravel, CRUD, Builder, Login, Authentication, Admin, Automated, Database">
    <meta name="robots" content="index, follow">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom-welcome.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero">
            <h1>Build CRUD Applications Effortlessly</h1>
            <p>Take your projects to the next level with automated CRUD generation, flexible customization, and seamless API integration. Start building your backend with ease!</p>
            <div class="buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
        
        <!-- Features Section -->
        <div class="features">
            <div class="feature-item">
                <h2>Effortless CRUD Generation</h2>
                <p>Generate standard and API CRUD operations quickly with a user-friendly interface, complete with model, migration, and controller generation.</p>
            </div>
            <div class="feature-item">
                <h2>Customizable Forms & Validation</h2>
                <p>Select fields, choose validation rules, and personalize each element to fit your application’s needs.</p>
            </div>
            <div class="feature-item">
                <h2>API Documentation Made Easy</h2>
                <p>Swagger API documentation is automatically generated, making it simple to manage and showcase your endpoints.</p>
            </div>
            <div class="feature-item">
                <h2>User Management & Permissions</h2>
                <p>Manage users with ease, utilizing roles, permissions, and permission groups to control access levels across your application.</p>
            </div>
            <div class="feature-item">
                <h2>Automated Model Relations</h2>
                <p>Define relationships between models effortlessly by selecting related models and setting relation types for seamless data integration.</p>
            </div>
            <div class="feature-item">
                <h2>Configure Essential Packages</h2>
                <p>Boost your development workflow by configuring essential packages. Set up key packages to streamline development, automate tasks, and enhance performance.</p>
            </div>            
        </div>

        <!-- Call to Action Section -->
        <div class="cta-section">
            <h2>Start Building with the CRUD Builder Now</h2>
            <p>Streamline your backend development and save valuable time with our CRUD builder. Designed to handle complex applications, it’s perfect for developers at all levels.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
        </div>

        <!-- Footer -->
        <footer>
            CRUD Builder v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
</body>
</html>
