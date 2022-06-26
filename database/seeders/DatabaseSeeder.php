<?php

namespace Database\Seeders;

use Database\Seeders\ReceiveOptionSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'fullname' => "Admin",
            'login_id' => "123456",
            'phone' => "123456789",
            'email' => "admin@info.com",
            'is_active' => 1,
            'ban_status' => 'active',
            'login_id' => '123456',
            'email_verified_at' => now()->addDay(rand(1, 6)),
            'phone_verified_at' => now()->addDay(rand(1, 6)),
            'password' => '123456789', // secret
            'user_type' => 'superadmin', // secret
            'gender' => 'male', // secret
        ]);

        $this->call(SettingSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(ReceiveOptionSeeder::class);

        Schema::disableForeignKeyConstraints();
        DB::unprepared(include database_path('Intial_data/countries.php'));
        DB::unprepared(include database_path('Intial_data/departments.php'));
        DB::unprepared(include database_path('Intial_data/rasid_jobs.php'));
        DB::unprepared(include database_path('Intial_data/users.php'));
        DB::unprepared(include database_path('Intial_data/admins.php'));
        DB::unprepared(include database_path('Intial_data/citizens.php'));
        DB::unprepared(include database_path('Intial_data/clients.php'));
        DB::unprepared(include database_path('Intial_data/banks.php'));
        DB::unprepared(include database_path('Intial_data/bank_accounts.php'));
        DB::unprepared(include database_path('Intial_data/app_media.php'));
        DB::unprepared(include database_path('Intial_data/slide.php'));
        Schema::enableForeignKeyConstraints();
    }
}
