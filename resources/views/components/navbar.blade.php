<nav class="glass-header sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center shadow-green">
                        <i class="fas fa-shield-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-charcoal">National Membership</h1>
                        <p class="text-xs text-gray-medium">Secure • Verified</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-charcoal hover:text-primary font-medium transition-colors">Home</a>
                <a href="{{ route('membership.register') }}" class="text-charcoal hover:text-primary font-medium transition-colors">Join Membership</a>
                @auth
                    <a href="{{ route('member.dashboard') }}" class="text-charcoal hover:text-primary font-medium transition-colors">Dashboard</a>
                    <form method="POST" action="{{ route('member.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-charcoal hover:text-primary font-medium transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('member.login') }}" class="btn-primary">Login</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-charcoal hover:text-primary">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4" style="display: none;">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="text-charcoal hover:text-primary py-2 transition-colors">Home</a>
                <a href="{{ route('membership.register') }}" class="text-charcoal hover:text-primary py-2 transition-colors">Join Membership</a>
                @auth
                    <a href="{{ route('member.dashboard') }}" class="text-charcoal hover:text-primary py-2 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('member.login') }}" class="text-charcoal hover:text-primary py-2 transition-colors">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

