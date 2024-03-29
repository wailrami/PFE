<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        for ($i = 0; $i < 10; $i++) {
            $user = \App\Models\User::factory()->create([
                'password' => bcrypt('12345678'),
                'role' => 'client',
                'tel' => '0666666666',
            ]);
            \App\Models\Gestionnaire::create([
                'user_id' => $user->id,
            ]);
        }
    }
}
