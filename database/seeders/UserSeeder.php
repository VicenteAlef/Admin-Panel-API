<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador Root',
            'email' => 'ildehislan@gmail.com', // Use um e-mail que você queira testar
            'password' => Hash::make('admin123'), // Defina a senha padrão
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
