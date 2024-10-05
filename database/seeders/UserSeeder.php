<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);

        User::factory(4)->create(['password' => Hash::make('1234')]);

        $adminUser = User::first();

        $adminRole = Role::where('name', 'Administrator')->first();
        $userRole = Role::where('name', 'User')->first();

        $users = User::whereNot('id', 1)->get();

        RoleUser::create([
            'role_id' => $adminRole->id,
            'user_id' => $adminUser->id,
        ]);

        foreach ($users as $user) {
            RoleUser::create([
                'role_id' => $userRole->id,
                'user_id' => $user->id
            ]);
        }
    }
}
