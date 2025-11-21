<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin') }} - Admin Panel</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .nav-links a {
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            position: relative;
            margin-right: 1.5rem;
        }
        
        .nav-links a:hover {
            color: white;
        }
        
        .nav-links a:before {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover:before {
            width: 100%;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .footer {
            background-color: #1e293b;
            color: #cbd5e1;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .table th {
            background-color: #f1f5f9;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #334155;
        }
        
        .table td {
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            color: #334155;
        }
        
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #22c55e;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #ef4444;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <nav class="navbar py-4">
                <div class="nav-brand">
                    <a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none; font-size: 1.75rem; font-weight: 700;">
                        Admin Panel
                    </a>
                </div>
                <div class="nav-links flex items-center">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.profile.index') }}">Profile</a>
                    <a href="{{ route('admin.skills.index') }}">Skills</a>
                    <a href="{{ route('admin.projects.index') }}">Projects</a>
                    <a href="{{ route('admin.services.index') }}">Services</a>
                    <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                    <a href="{{ route('admin.messages.index') }}">Messages</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: rgba(255, 255, 255, 0.9); cursor: pointer; margin-left: 1.5rem; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255, 255, 255, 0.9)'">Logout</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>

    <main class="py-8">
        <div class="container">
            @if(session('success'))
                <div class="alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error mb-6">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card p-6">
                {{ $slot }}
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }} Admin Panel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>