<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'root',
            'email' => 'root@email.com',
            'password' => 'root',
            'role' => Role::SYSTEM_ADMIN,
        ]);
    }
}
