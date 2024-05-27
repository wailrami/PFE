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

        $user = \App\Models\User::factory()->create([
            'nom' => 'admin',
            'prenom' => 'admin',
            'email' => 'rami242003@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'tel' => '0561556617',    
        ]);

        $user = \App\Models\User::factory()->create([
            'nom' => 'gestionnaire',
            'prenom' => 'gestionnaire',
            'email' => 'ramidz242003@gmail.com',
            'password' => bcrypt('12345678'),
            'tel' => '0666666666',
            'role' => 'gestionnaire',
            
        ]);
        \App\Models\Gestionnaire::create([
            'user_id' => $user->id,
            'status' => 'accepted',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $user = \App\Models\User::factory()->create([
                'password' => bcrypt('12345678'),
                'tel' => '0666666666',
                'role' => 'gestionnaire',
                
            ]);
            \App\Models\Gestionnaire::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $user = \App\Models\User::factory()->create([
                'password' => bcrypt('12345678'),
                'tel' => '0666666666',
                'role' => 'gestionnaire',
                
            ]);
            \App\Models\Gestionnaire::create([
                'user_id' => $user->id,
                'status' => 'accepted',
            ]);
        }
    }
}
