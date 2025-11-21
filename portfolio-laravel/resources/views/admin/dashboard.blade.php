<x-admin-layout>
    <div class="container">
        <h1 style="font-size: 2rem; margin-bottom: 2rem;">Admin Dashboard</h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div class="card" style="text-align: center;">
                <h3>Projects</h3>
                <p style="font-size: 2rem; font-weight: bold;">{{ $projectCount }}</p>
                <a href="{{ route('admin.projects.index') }}" class="btn" style="margin-top: 1rem;">Manage Projects</a>
            </div>
            
            <div class="card" style="text-align: center;">
                <h3>Skills</h3>
                <p style="font-size: 2rem; font-weight: bold;">{{ $skillCount }}</p>
                <a href="{{ route('admin.skills.index') }}" class="btn" style="margin-top: 1rem;">Manage Skills</a>
            </div>
            
            <div class="card" style="text-align: center;">
                <h3>Services</h3>
                <p style="font-size: 2rem; font-weight: bold;">{{ $serviceCount }}</p>
                <a href="{{ route('admin.services.index') }}" class="btn" style="margin-top: 1rem;">Manage Services</a>
            </div>
            
            <div class="card" style="text-align: center;">
                <h3>Testimonials</h3>
                <p style="font-size: 2rem; font-weight: bold;">{{ $testimonialCount }}</p>
                <a href="{{ route('admin.testimonials.index') }}" class="btn" style="margin-top: 1rem;">Manage Testimonials</a>
            </div>
            
            <div class="card" style="text-align: center;">
                <h3>Messages</h3>
                <p style="font-size: 2rem; font-weight: bold;">{{ $messageCount }}</p>
                <a href="{{ route('admin.messages.index') }}" class="btn" style="margin-top: 1rem;">View Messages</a>
            </div>
        </div>
        
        <div class="card">
            <h2 style="margin-bottom: 1rem;">Quick Actions</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                <a href="{{ route('admin.profile.index') }}" class="btn" style="background-color: #17a2b8; color: white;">Edit Profile</a>
                <a href="{{ route('admin.projects.create') }}" class="btn" style="background-color: #28a745; color: white;">Add New Project</a>
                <a href="{{ route('admin.skills.create') }}" class="btn" style="background-color: #ffc107; color: black;">Add New Skill</a>
                <a href="{{ route('admin.services.create') }}" class="btn" style="background-color: #6f42c1; color: white;">Add New Service</a>
                <a href="{{ route('admin.testimonials.create') }}" class="btn" style="background-color: #e83e8c; color: white;">Add New Testimonial</a>
            </div>
        </div>
    </div>
</x-admin-layout>