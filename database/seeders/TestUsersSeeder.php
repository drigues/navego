<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@navego.pt'],
            [
                'name'              => 'Admin Navego',
                'password'          => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        // 2. Prestador
        $prestador = User::updateOrCreate(
            ['email' => 'prestador@navego.pt'],
            [
                'name'              => 'João Silva Advogado',
                'password'          => Hash::make('prestador123'),
                'email_verified_at' => now(),
            ]
        );
        $prestador->syncRoles(['provider']);

        Provider::updateOrCreate(
            ['slug' => 'joao-silva-associados'],
            [
                'user_id'       => $prestador->id,
                'business_name' => 'João Silva & Associados',
                'slug'          => 'joao-silva-associados',
                'description'   => 'Advogado especializado em imigração e nacionalidade portuguesa',
                'status'        => Provider::STATUS_ACTIVE,
                'plan'          => Provider::PLAN_BASIC,
            ]
        );

        $this->command->info('✓ admin@navego.pt / admin123 (role: admin)');
        $this->command->info('✓ prestador@navego.pt / prestador123 (role: provider) → João Silva & Associados');
    }
}
