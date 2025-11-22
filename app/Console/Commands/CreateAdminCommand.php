<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--name=Admin : Admin user name}
                            {--email= : Admin email address}
                            {--password= : Admin password (will be prompted if not provided)}
                            {--role=super_admin : Admin role (super_admin, admin, moderator, viewer)}
                            {--force : Force update if user exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user for the membership system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email') ?: $this->ask('Email address');
        $password = $this->option('password') ?: $this->secret('Password');
        $role = $this->option('role');

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address!');
            return Command::FAILURE;
        }

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            if ($this->option('force') || $this->confirm('User with this email already exists. Update password?', false)) {
                $existingUser->update([
                    'password' => Hash::make($password),
                    'is_active' => true,
                    'role' => $role,
                ]);
                $this->info('✅ Admin user updated successfully!');
                $this->table(
                    ['Field', 'Value'],
                    [
                        ['ID', $existingUser->id],
                        ['Name', $existingUser->name],
                        ['Email', $existingUser->email],
                        ['Role', $existingUser->role],
                        ['Status', $existingUser->is_active ? 'Active' : 'Inactive'],
                    ]
                );
                return Command::SUCCESS;
            }
            $this->error('User with this email already exists! Use --force to update or choose a different email.');
            return Command::FAILURE;
        }

        // Validate password
        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters!');
            return Command::FAILURE;
        }

        // Validate role
        $allowedRoles = ['super_admin', 'admin', 'moderator', 'viewer'];
        if (!in_array($role, $allowedRoles)) {
            $this->error('Invalid role! Allowed: ' . implode(', ', $allowedRoles));
            return Command::FAILURE;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->info('✅ Admin user created successfully!');
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $user->id],
                    ['Name', $user->name],
                    ['Email', $user->email],
                    ['Role', $user->role],
                    ['Status', $user->is_active ? 'Active' : 'Inactive'],
                ]
            );

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

