<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // 1. Roles e permissions (Spatie)
            UserSeeder::class,      // 2. Admin, providers, users
            CategorySeeder::class,  // 3. Categorias
            ProviderSeeder::class,  // 4. Perfis de prestadores
            QuoteSeeder::class,     // 5. Orçamentos de teste
            GuideSeeder::class,     // 6. Guias para imigrantes
            NewsSeeder::class,      // 7. Notícias
            TestUsersSeeder::class, // 8. Utilizadores de teste
        ]);
    }
}
