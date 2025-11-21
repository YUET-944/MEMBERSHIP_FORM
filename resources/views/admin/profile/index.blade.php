<x-admin-layout>
    <div class="container">
        <h1 class="text-2xl font-bold mb-6">Profile Settings</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $profile->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    
                    <div class="mb-4">
                        <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                        <textarea name="bio" id="bio" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>
                
                <!-- Theme Selection -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Theme Settings</h2>
                    
                    <div class="mb-4">
                        <label for="theme" class="block text-gray-700 text-sm font-bold mb-2">Select Theme</label>
                        <select name="theme" id="theme" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="default" {{ old('theme', $profile->theme) == 'default' ? 'selected' : '' }}>Default Theme</option>
                            <option value="dark" {{ old('theme', $profile->theme) == 'dark' ? 'selected' : '' }}>Dark Theme</option>
                            <option value="light" {{ old('theme', $profile->theme) == 'light' ? 'selected' : '' }}>Light Theme</option>
                            <option value="blue" {{ old('theme', $profile->theme) == 'blue' ? 'selected' : '' }}>Blue Theme</option>
                            <option value="green" {{ old('theme', $profile->theme) == 'green' ? 'selected' : '' }}>Green Theme</option>
                            <option value="purple" {{ old('theme', $profile->theme) == 'purple' ? 'selected' : '' }}>Purple Theme</option>
                            <option value="orange" {{ old('theme', $profile->theme) == 'orange' ? 'selected' : '' }}>Orange Theme</option>
                            <option value="pink" {{ old('theme', $profile->theme) == 'pink' ? 'selected' : '' }}>Pink Theme</option>
                            <option value="red" {{ old('theme', $profile->theme) == 'red' ? 'selected' : '' }}>Red Theme</option>
                            <option value="cyan" {{ old('theme', $profile->theme) == 'cyan' ? 'selected' : '' }}>Cyan Theme</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Theme Preview</label>
                        <div class="flex flex-wrap gap-2">
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" data-theme="default"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);" data-theme="dark"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);" data-theme="light"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);" data-theme="blue"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);" data-theme="green"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);" data-theme="purple"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);" data-theme="pink"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);" data-theme="orange"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #ff5858 0%, #f09819 100%);" data-theme="red"></div>
                            <div class="w-8 h-8 rounded cursor-pointer border-2 border-transparent hover:border-gray-300" style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);" data-theme="cyan"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div class="bg-white shadow-md rounded-lg p-6 md:col-span-2">
                    <h2 class="text-xl font-semibold mb-4">Social Links</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="facebook_url" class="block text-gray-700 text-sm font-bold mb-2">Facebook URL</label>
                            <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $profile->facebook_url) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div>
                            <label for="twitter_url" class="block text-gray-700 text-sm font-bold mb-2">Twitter URL</label>
                            <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $profile->twitter_url) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div>
                            <label for="linkedin_url" class="block text-gray-700 text-sm font-bold mb-2">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div>
                            <label for="youtube_url" class="block text-gray-700 text-sm font-bold mb-2">YouTube URL</label>
                            <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $profile->youtube_url) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div>
                            <label for="instagram_url" class="block text-gray-700 text-sm font-bold mb-2">Instagram URL</label>
                            <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themePreviews = document.querySelectorAll('[data-theme]');
            const themeSelect = document.getElementById('theme');
            
            themePreviews.forEach(preview => {
                preview.addEventListener('click', function() {
                    const theme = this.getAttribute('data-theme');
                    themeSelect.value = theme;
                });
            });
        });
    </script>
</x-admin-layout>