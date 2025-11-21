<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfileSetting;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create profile setting
        ProfileSetting::create([
            'name' => 'John Doe',
            'title' => 'Full Stack Developer',
            'bio' => 'I am a passionate full-stack developer with over 5 years of experience building web applications using modern technologies like Laravel, Vue.js, and React. I love creating beautiful, functional, and user-friendly digital experiences.',
            'profile_avatar' => 'avatar1.png',
            'facebook_url' => 'https://facebook.com/johndoe',
            'twitter_url' => 'https://twitter.com/johndoe',
            'linkedin_url' => 'https://linkedin.com/in/johndoe',
            'youtube_url' => 'https://youtube.com/johndoe',
            'instagram_url' => 'https://instagram.com/johndoe',
        ]);

        // Create skills
        $skills = [
            ['name' => 'PHP', 'category' => 'Backend', 'level' => 90, 'icon' => 'fab fa-php'],
            ['name' => 'Laravel', 'category' => 'Backend', 'level' => 85, 'icon' => 'fab fa-laravel'],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'level' => 80, 'icon' => 'fab fa-js'],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'level' => 75, 'icon' => 'fab fa-vuejs'],
            ['name' => 'React', 'category' => 'Frontend', 'level' => 70, 'icon' => 'fab fa-react'],
            ['name' => 'HTML/CSS', 'category' => 'Frontend', 'level' => 95, 'icon' => 'fab fa-html5'],
            ['name' => 'MySQL', 'category' => 'Database', 'level' => 85, 'icon' => 'fas fa-database'],
            ['name' => 'Git', 'category' => 'Tools', 'level' => 80, 'icon' => 'fab fa-git'],
        ];

        foreach ($skills as $skillData) {
            Skill::create($skillData);
        }

        // Create projects
        $projects = [
            [
                'name' => 'E-Commerce Platform',
                'slug' => 'e-commerce-platform',
                'description' => 'A full-featured e-commerce platform built with Laravel and Vue.js. Features include product management, shopping cart, payment processing, and user authentication.',
                'thumbnail' => 'project1.jpg',
                'tags' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe'],
                'github_url' => 'https://github.com/johndoe/ecommerce-platform',
                'live_url' => 'https://ecommerce.example.com',
                'status' => 'published',
            ],
            [
                'name' => 'Task Management App',
                'slug' => 'task-management-app',
                'description' => 'A task management application with real-time updates, team collaboration features, and drag-and-drop interface. Built with Laravel, React, and WebSockets.',
                'thumbnail' => 'project2.jpg',
                'tags' => ['Laravel', 'React', 'WebSocket', 'MySQL'],
                'github_url' => 'https://github.com/johndoe/task-manager',
                'live_url' => 'https://tasks.example.com',
                'status' => 'published',
            ],
            [
                'name' => 'Portfolio Website',
                'slug' => 'portfolio-website',
                'description' => 'A responsive portfolio website showcasing my work and skills. Built with Laravel, Tailwind CSS, and Alpine.js.',
                'thumbnail' => 'project3.jpg',
                'tags' => ['Laravel', 'Tailwind CSS', 'Alpine.js'],
                'github_url' => 'https://github.com/johndoe/portfolio',
                'live_url' => 'https://portfolio.example.com',
                'status' => 'published',
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        // Create services
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Custom web development solutions tailored to your business needs. From simple websites to complex web applications.',
                'icon' => 'fas fa-laptop-code',
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Cross-platform mobile applications built with React Native that work seamlessly on both iOS and Android devices.',
                'icon' => 'fas fa-mobile-alt',
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'User-centered design approach to create intuitive and engaging user interfaces that enhance user experience.',
                'icon' => 'fas fa-paint-brush',
            ],
            [
                'title' => 'API Development',
                'description' => 'RESTful API development with proper documentation and testing to integrate with third-party services.',
                'icon' => 'fas fa-plug',
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Create testimonials
        $testimonials = [
            [
                'client_name' => 'Sarah Johnson',
                'client_photo' => 'client1.jpg',
                'review' => 'John delivered our e-commerce platform on time and exceeded our expectations. His attention to detail and technical expertise are impressive. We\'ll definitely work with him again!',
                'rating' => 5,
            ],
            [
                'client_name' => 'Michael Chen',
                'client_photo' => 'client2.jpg',
                'review' => 'Working with John was a great experience. He understood our requirements perfectly and built exactly what we needed. The website has been running smoothly for months now.',
                'rating' => 4,
            ],
            [
                'client_name' => 'Emma Rodriguez',
                'client_photo' => 'client3.jpg',
                'review' => 'John is a talented developer who takes the time to understand your business. The task management app he built for us has improved our team\'s productivity significantly.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }
    }
}