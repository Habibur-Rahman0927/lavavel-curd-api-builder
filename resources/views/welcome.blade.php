<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Builder - Power Up Your Projects</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'figtree', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            color: #333;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 100px 20px;
            background: linear-gradient(145deg, #0066cc, #0099ff);
            color: white;
            border-radius: 20px;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
        }
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
        }
        .hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin-bottom: 30px;
        }
        .buttons {
            display: flex;
            gap: 15px;
        }
        .btn {
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            transition: background 0.3s ease;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #ffffff;
            color: #0066cc;
        }
        .btn-primary:hover {
            background-color: #f2f2f2;
        }
        .features {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 60px;
            padding: 40px 0;
            background-color: #f1faff;
            border-radius: 20px;
        }
        .feature-item {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .feature-item:hover {
            transform: translateY(-10px);
        }
        .feature-item h2 {
            color: #0066cc;
            font-size: 1.7rem;
            margin-bottom: 15px;
        }
        .feature-item p {
            color: #555;
        }
        .cta-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 60px 20px;
            background-color: #0066cc;
            color: white;
            border-radius: 20px;
            margin-top: 60px;
        }
        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .cta-section p {
            max-width: 700px;
            margin-bottom: 30px;
        }
        footer {
            padding: 20px;
            text-align: center;
            color: #777;
            font-size: 0.9rem;
            margin-top: 60px;
        }
    </style>
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
