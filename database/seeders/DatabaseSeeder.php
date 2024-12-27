<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('roles')->insert([
            ['id' => Str::uuid(), 'name' => 'admin'],
            ['id' => Str::uuid(), 'name' => 'user'],
        ]);


        $role = DB::table('roles')->where('name', 'admin')->first();

        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $role->id
            ],
        ]);
    }
}
