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

        // $user = \App\Models\User::create([
        //     'fullname' => "Citizen",
        //     'phone' => "0555227711",
        //     'identity_number' => '1234567891',
        //     'is_active' => 1,
        //     'ban_status' => 'active',
        //     'register_status' => 'completed',
        //     'email_verified_at' => now()->addDay(rand(1, 6)),
        //     'phone_verified_at' => now()->addDay(rand(1, 6)),
        //     'password' => 'Aa@100200300', // secret
        //     'user_type' => 'citizen', // secret
        //     'gender' => 'male', // secret
        // ]);
        //
        // $user->citizenWallet()->create([
        //     'wallet_number' => generate_unique_code(CitizenWallet::class, 'wallet_number', 10, 'numbers')
        // ]);
        //
         $this->call(SettingSeeder::class);
         $this->call(CountrySeeder::class);
         $this->call(CountryTransSeeder::class);
         $this->call(SlideSeeder::class);
         $this->call(LinkSeeder::class);
         $this->call(ReceiveOptionSeeder::class);
         $this->call(SettingSeeder::class);
         $this->call(TransferRelationSeeder::class);
        // $this->call(TransactionSeeder::class);
        //  $this->call(PackageSeeder::class);
        // $this->call(ReceiveOptionSeeder::class);
        // $this->call(TransferRelationSeeder::class);
        // $this->call(NotificationSeeder::class);
        // // Contact::factory(50)->create();
        // Schema::disableForeignKeyConstraints();
        // DB::unprepared(include database_path('Intial_data/departments.php'));
        // DB::unprepared(include database_path('Intial_data/rasid_jobs.php'));
        // DB::unprepared(include database_path('Intial_data/users.php'));
        // DB::unprepared(include database_path('Intial_data/admins.php'));
        // DB::unprepared(include database_path('Intial_data/citizens.php'));
        // DB::unprepared(include database_path('Intial_data/clients.php'));
        // DB::unprepared(include database_path('Intial_data/banks.php'));
        // DB::unprepared(include database_path('Intial_data/bank_accounts.php'));
        // DB::unprepared(include database_path('Intial_data/app_media.php'));
        // DB::unprepared(include database_path('Intial_data/slide.php'));
        // Schema::enableForeignKeyConstraints();
    }
}
