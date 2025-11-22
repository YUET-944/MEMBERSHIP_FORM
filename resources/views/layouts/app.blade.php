<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ur' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Security Headers -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <title>@yield('title', 'Membership Registration') - {{ config('app.name', 'National Membership System') }}</title>
    
    <!-- Premium Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Urdu Font -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js"></script>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/premium.css', 'resources/css/ultra-premium.css', 'resources/css/revolutionary-ui.css', 'resources/css/3d-glass-morphism.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        :root {
            /* Premium Color Palette */
            --primary-green: #1e4d2b;
            --secondary-green: #2d6a4f;
            --accent-green: #40916c;
            --light-green: #52b788;
            --accent-gold: #d4af37;
            --accent-coral: #FF6B6B;
            --bg-cream: #FEFBF6;
            --bg-white: #FFFFFF;
            --bg-light-gray: #F8F9FA;
            --text-charcoal: #2d3748;
            --text-dark: #2c3e50;
            --text-gray: #6c757d;
            --border-light: #e0e0e0;
            
            /* Typography */
            --font-serif: 'Playfair Display', serif;
            --font-sans: 'Inter', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            
            /* Shadows - 8-layer system */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-gold: 0 10px 25px -5px rgba(212, 175, 55, 0.3);
            --shadow-green: 0 10px 25px -5px rgba(30, 77, 43, 0.2);
            
            /* Border Radius Scale */
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }
        
        body {
            font-family: var(--font-sans);
            background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            color: var(--text-charcoal);
            line-height: 1.6;
        }
        
        /* Premium Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-serif);
            font-weight: 700;
            color: var(--primary-green);
            line-height: 1.2;
        }
        
        .font-serif {
            font-family: var(--font-serif);
        }
        
        .font-mono {
            font-family: var(--font-mono);
        }
        
        /* Premium Glassmorphism - Multi-layered */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(30, 77, 43, 0.15);
            box-shadow: var(--shadow-xl), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            position: relative;
        }
        
        .glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.3), transparent);
        }
        
        /* Luxury Card System */
        .luxury-card {
            background: var(--bg-white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-2xl);
            border: 1px solid rgba(30, 77, 43, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .luxury-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
        }
        
        /* Mirror Effect - Subtle */
        .mirror-effect::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to bottom, 
                rgba(30, 77, 43, 0.03) 0%, 
                rgba(30, 77, 43, 0.01) 50%,
                transparent 100%);
            transform: scaleY(-1);
            opacity: 0.3;
            pointer-events: none;
        }
        
        /* Urdu Text */
        .urdu-text {
            font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;
            direction: rtl;
            text-align: right;
        }
        
        /* Premium Form Inputs with Floating Labels */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 1.25rem 1rem 0.75rem;
            background: var(--bg-white);
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            color: var(--text-charcoal);
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }
        
        .form-input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(30, 77, 43, 0.1), var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .form-input:focus + .floating-label,
        .form-input:not(:placeholder-shown) + .floating-label {
            transform: translateY(-1.5rem) scale(0.85);
            color: var(--primary-green);
            font-weight: 600;
        }
        
        .form-input::placeholder {
            color: transparent;
        }
        
        .floating-label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: var(--text-gray);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--bg-white);
            padding: 0 0.5rem;
            font-size: 1rem;
        }
        
        /* Important Fields - Gold Gradient Border */
        .form-input.important {
            border-image: linear-gradient(135deg, var(--accent-gold), #f4d03f) 1;
            border-width: 2px;
        }
        
        .form-input.important:focus {
            border-image: linear-gradient(135deg, var(--accent-gold), #f4d03f) 1;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2), var(--shadow-gold);
        }
        
        /* Validation Icons */
        .validation-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .form-input.valid + .validation-icon.check {
            opacity: 1;
            color: var(--accent-green);
        }
        
        .form-input.invalid + .validation-icon.x {
            opacity: 1;
            color: var(--accent-coral);
        }
        
        /* Premium Buttons with Ripple Effect */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-green);
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--accent-green) 100%);
        }
        
        .btn-primary:active::before {
            width: 300px;
            height: 300px;
        }
        
        /* Gold Accent Button */
        .btn-accent {
            background: linear-gradient(135deg, var(--accent-gold) 0%, #f4d03f 100%);
            color: var(--text-charcoal);
            border: none;
            border-radius: var(--radius-md);
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
        }
        
        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-gold);
        }
        
        /* Coral Action Button */
        .btn-coral {
            background: linear-gradient(135deg, var(--accent-coral) 0%, #ff8787 100%);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }
        
        .btn-coral:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
        }
        
        /* Premium Section Headers */
        .section-header {
            font-family: var(--font-serif);
            color: var(--primary-green);
            font-size: 2rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
            border-radius: var(--radius-sm);
        }
        
        /* Progress Orchid Indicator */
        .progress-orchid {
            position: relative;
            width: 100%;
            height: 8px;
            background: var(--bg-light-gray);
            border-radius: var(--radius-xl);
            overflow: hidden;
        }
        
        .progress-orchid-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
            border-radius: var(--radius-xl);
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .progress-orchid-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Loading Spinner */
        .spinner {
            border: 3px solid rgba(30, 77, 43, 0.2);
            border-top: 3px solid var(--primary-green);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Text Colors */
        .text-primary-green {
            color: var(--primary-green);
        }
        
        .text-accent-gold {
            color: var(--accent-gold);
        }
        
        .text-accent-coral {
            color: var(--accent-coral);
        }
        
        /* Background Colors */
        .bg-cream {
            background-color: var(--bg-cream);
        }
        
        .bg-light-gray {
            background-color: var(--bg-light-gray);
        }
    </style>
</head>
<body>
    <!-- Background Pattern - Subtle for Light Theme -->
    <div class="fixed inset-0 opacity-5 pointer-events-none">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(30, 77, 43, 0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Main Content -->
    <div class="relative z-10">
        @yield('content')
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>

