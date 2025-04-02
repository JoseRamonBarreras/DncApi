<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'SISTEMAS',
            'email' => 'admin.app@lechelaimperial.com',
            'password' => bcrypt('temporal')
        ]);
        $user->assignRole('SISTEMAS');

        $userProfile = Profile::create([
            'favorite_pet' => 'Cachorros',
            'user_id' => $user->id
        ]);
    }
}
