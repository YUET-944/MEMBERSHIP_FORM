<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateEncryptionKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encryption:generate-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new encryption key for AES-256 encryption';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = base64_encode(random_bytes(32));
        
        $this->info('Encryption key generated successfully!');
        $this->newLine();
        $this->line('Add this to your .env file:');
        $this->line("ENCRYPTION_KEY={$key}");
        $this->newLine();
        $this->warn('⚠️  Keep this key secure and never commit it to version control!');
        
        return Command::SUCCESS;
    }
}

