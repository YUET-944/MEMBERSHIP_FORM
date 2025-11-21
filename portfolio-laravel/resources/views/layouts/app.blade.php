<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme ?? 'default' }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Portfolio') }}</title>

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/themes.css') }}">

    <!-- Google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <!--
      - #MAIN
    -->
    <main>
        {{ $slot }}
    </main>
    
    <!-- Admin Button -->
    <div class="admin-button-container">
        <a href="{{ route('login') }}" class="admin-button" title="Admin Panel">
            <ion-icon name="lock-closed-outline"></ion-icon>
        </a>
    </div>
    
    <!-- Footer -->
    <x-footer />
    
    <!-- JavaScript for sidebar toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarBtn = document.querySelector('[data-sidebar-btn]');
            const sidebar = document.querySelector('[data-sidebar]');
            
            if (sidebarBtn && sidebar) {
                sidebarBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
            
            // Navbar link activation
            const navLinks = document.querySelectorAll('[data-nav-link]');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Hide all articles
                    const articles = document.querySelectorAll('article[data-page]');
                    articles.forEach(article => {
                        article.classList.remove('active');
                    });
                    
                    // Show the selected article
                    const targetPage = this.getAttribute('data-nav-link');
                    const targetArticle = document.querySelector(`article[data-page="${targetPage}"]`);
                    if (targetArticle) {
                        targetArticle.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>