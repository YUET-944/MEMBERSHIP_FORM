<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the avatars directory if it doesn't exist
        $avatarsDir = public_path('avatars');
        if (!file_exists($avatarsDir)) {
            mkdir($avatarsDir, 0755, true);
        }
        
        // Create 20 placeholder avatar files
        for ($i = 1; $i <= 20; $i++) {
            $avatarPath = $avatarsDir . '/avatar' . $i . '.png';
            if (!file_exists($avatarPath)) {
                // Create a simple SVG placeholder image instead of using GD
                $svgContent = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
                    <rect width="200" height="200" fill="#' . dechex(rand(0, 16777215)) . '" />
                    <text x="100" y="110" font-family="Arial" font-size="24" fill="white" text-anchor="middle">Avatar ' . $i . '</text>
                </svg>';
                
                file_put_contents($avatarPath, $svgContent);
            }
        }
    }
}