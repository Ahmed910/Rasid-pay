<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //        \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'fullname' => "Admin",
            'login_id' => "123456",
            'phone' => "123456789",
            'email' => "admin@info.com",
            'is_active' => 1,
            'ban_status' => 'active',
            'email_verified_at' => now()->addDay(rand(1, 6)),
            'phone_verified_at' => now()->addDay(rand(1, 6)),
            'password' => '123456789', // secret
            'user_type' => 'superadmin', // secret
            'gender' => 'male', // secret
        ]);

        $this->call(SettingSeeder::class);
    }
}
