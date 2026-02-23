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
            CategorySeeder::class,  // 3. Categorias de serviços
            ProviderSeeder::class,  // 4. Perfis de prestadores
            ServiceSeeder::class,   // 5. Serviços oferecidos
            QuoteSeeder::class,     // 6. Orçamentos de teste
            GuideSeeder::class,     // 7. Guias para imigrantes
            NewsSeeder::class,      // 8. Notícias
        ]);
    }
}
