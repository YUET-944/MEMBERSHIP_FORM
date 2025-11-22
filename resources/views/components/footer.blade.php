<footer class="bg-accent-dark text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-lg mb-4">National Membership System</h3>
                <p class="text-gray-400 text-sm">Secure, verified membership platform for individuals.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                    <li><a href="{{ route('membership.register') }}" class="hover:text-primary transition-colors">Join Membership</a></li>
                    <li><a href="{{ route('member.login') }}" class="hover:text-primary transition-colors">Member Login</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-primary transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Security</h4>
                <div class="flex space-x-4">
                    <i class="fas fa-lock text-primary"></i>
                    <i class="fas fa-shield-alt text-primary"></i>
                    <i class="fas fa-check-circle text-primary"></i>
                </div>
                <p class="text-gray-400 text-sm mt-4">Government-level security standards</p>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} National Membership System. All rights reserved.</p>
        </div>
    </div>
</footer>

