<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $email = $this->ask('Email admin');
        $name = $this->ask('Nama admin');
        $password = $this->secret('Password admin');

        $admin = Admin::create([
            'email' => $email,
            'nama' => $name,
            'password' => Hash::make($password),
        ]);

        $this->info("Admin berhasil dibuat: {$admin->email}");
    }
}
