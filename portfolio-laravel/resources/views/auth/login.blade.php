<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden login-card transform transition-all duration-500 hover:scale-[1.02]">
                <!-- Header with gradient -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10 text-center">
                    <div class="flex justify-center mb-6">
                        <div class="bg-white p-3 rounded-full shadow-lg">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">Admin Portal</h2>
                    <p class="text-indigo-200">Sign in to access your dashboard</p>
                </div>
                
                <!-- Form content -->
                <div class="px-8 py-10">
                    <!-- Display errors -->
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg mb-6 form-element border-l-4 border-red-500">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg mb-6 form-element border-l-4 border-red-500">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Login form -->
                    <form class="mt-4 space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-4">
                            <!-- Email field -->
                            <div class="form-element">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        id="email" 
                                        name="email" 
                                        type="email" 
                                        autocomplete="email" 
                                        required 
                                        class="appearance-none relative block w-full pl-10 pr-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition duration-300 input-field shadow-sm"
                                        placeholder="Enter your email">
                                </div>
                            </div>
                            
                            <!-- Password field -->
                            <div class="form-element">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input 
                                        id="password" 
                                        name="password" 
                                        type="password" 
                                        autocomplete="current-password" 
                                        required 
                                        class="appearance-none relative block w-full pl-10 pr-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition duration-300 input-field shadow-sm"
                                        placeholder="Enter your password">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Remember me and forgot password -->
                        <div class="flex items-center justify-between form-element">
                            <div class="flex items-center">
                                <input 
                                    id="remember-me" 
                                    name="remember-me" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>
                            
                            <div class="text-sm">
                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-300">
                                    Forgot password?
                                </a>
                            </div>
                        </div>
                        
                        <!-- Submit button -->
                        <div class="form-element">
                            <button 
                                type="submit" 
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl login-button">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-indigo-400 group-hover:text-indigo-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Sign in to dashboard
                            </button>
                        </div>
                    </form>
                    
                    <!-- Demo credentials -->
                    <div class="mt-8 bg-gradient-to-r from-gray-50 to-gray-100 p-5 rounded-xl form-element border border-gray-200">
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Demo Credentials</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><span class="font-semibold">Email:</span> admin@admin.com</p>
                                <p><span class="font-semibold">Password:</span> admin123</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-6 text-center">
                    <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-300 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>