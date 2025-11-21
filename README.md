# Laravel Portfolio Website

A complete, production-ready Portfolio Website built with Laravel 11, MySQL, TailwindCSS, Blade components, and Laravel Breeze for authentication.

## Features

### Public Portfolio Website
- Hero section with name, title, avatar
- About section
- Skills section (icons + levels)
- Projects section (with project thumbnails, GitHub link, live link, tags)
- Services section
- Testimonials section
- Contact page with form
- Footer with social links

### Admin Panel
- Dashboard with statistics
- Profile management (name, title, bio, social links, avatar selection)
- Skills management (CRUD operations)
- Projects management (CRUD operations)
- Services management (CRUD operations)
- Testimonials management (CRUD operations)
- Contact messages management (view and delete)

## Technical Implementation

### Backend
- Laravel 11 framework
- MySQL database
- Laravel Breeze for authentication
- MVC architecture
- Form request validation
- Repository pattern (optional)
- Laravel Policies for admin access
- Database migrations and seeders

### Frontend
- TailwindCSS for styling
- Blade components for reusable UI elements
- Responsive design
- Modern, premium, gradient-based design
- Glassmorphism elements
- Smooth animations

### Database Structure
- Users (Breeze)
- Profile Settings
- Skills
- Projects
- Services
- Testimonials
- Contact Messages

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database settings
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan db:seed` to populate with sample data
7. Run `npm install` and `npm run dev` to compile assets
8. Start the development server with `php artisan serve`

## Deployment
See `DEPLOYMENT_INSTRUCTIONS.md` for detailed deployment instructions for Hostinger hPanel.

## Database ERD
See `ERD.txt` for the text-based database entity relationship diagram.

## License
This project is open-source and available under the MIT License.