<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@navego.pt'],
            [
                'name' => 'Admin Navego',
                'password' => Hash::make('password'),
                'phone' => '+351 910 000 001',
                'nationality' => 'Portuguesa',
                'preferred_language' => 'pt',
                'city' => 'Lisboa',
                'district' => 'Lisboa',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Provider users
        $providerData = [
            [
                'name' => 'Ana Silva',
                'email' => 'ana.silva@navego.pt',
                'nationality' => 'Portuguesa',
                'city' => 'Lisboa',
                'district' => 'Lisboa',
                'phone' => '+351 912 345 678',
            ],
            [
                'name' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@navego.pt',
                'nationality' => 'Portuguesa',
                'city' => 'Porto',
                'district' => 'Porto',
                'phone' => '+351 922 345 678',
            ],
            [
                'name' => 'Maria João Costa',
                'email' => 'maria.costa@navego.pt',
                'nationality' => 'Portuguesa',
                'city' => 'Braga',
                'district' => 'Braga',
                'phone' => '+351 932 345 678',
            ],
        ];

        foreach ($providerData as $data) {
            $provider = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('password'),
                    'preferred_language' => 'pt',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ])
            );
            $provider->assignRole('provider');
        }

        // Regular users (immigrants)
        $userData = [
            [
                'name' => 'João Santos',
                'email' => 'joao@example.com',
                'nationality' => 'Brasileira',
                'city' => 'Lisboa',
                'district' => 'Lisboa',
                'phone' => '+351 963 456 789',
                'preferred_language' => 'pt',
            ],
            [
                'name' => 'Olha Kovalenko',
                'email' => 'olha@example.com',
                'nationality' => 'Ucraniana',
                'city' => 'Porto',
                'district' => 'Porto',
                'phone' => '+351 963 456 790',
                'preferred_language' => 'en',
            ],
            [
                'name' => 'Amara Diallo',
                'email' => 'amara@example.com',
                'nationality' => 'Guineense',
                'city' => 'Lisboa',
                'district' => 'Lisboa',
                'phone' => '+351 963 456 791',
                'preferred_language' => 'pt',
            ],
            [
                'name' => 'Priya Nair',
                'email' => 'priya@example.com',
                'nationality' => 'Indiana',
                'city' => 'Faro',
                'district' => 'Faro',
                'phone' => '+351 963 456 792',
                'preferred_language' => 'en',
            ],
        ];

        foreach ($userData as $data) {
            $regularUser = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ])
            );
            $regularUser->assignRole('user');
        }
    }
}
