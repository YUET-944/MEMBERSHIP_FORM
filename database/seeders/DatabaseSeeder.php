<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $this->call(AdminUserSeeder::class);
        
        // Create test user (if needed)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Run the avatar seeder
        $this->call(AvatarSeeder::class);
        
        // Run the sample data seeder
        $this->call(SampleDataSeeder::class);
    }
}