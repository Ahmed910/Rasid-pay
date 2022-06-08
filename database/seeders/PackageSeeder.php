<?php

namespace Database\Seeders;


use App\Models\Package\Package;
use App\Models\Package\PackageTranslation;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'id' => '3cfb9746-9779-4lj-8371-12545c9fca53',
                'color' => '#fff',
                'price' => '1234',
                'duration' => '12',
                'discount' => '10',
                'is_active' => true
            ],
            [
                'id' => '3cfb9746-9779-4lj-8371-5fjk35c9fca53',
                'color' => '#fff',
                'price' => '2345',
                'duration' => '12',
                'discount' => '15',
                'is_active' => true
            ],
            [
                'id' => '3cfb9746-9779-4lj-6688-12545c3hca53',
                'color' => '#fff',
                'price' => '6455',
                'duration' => '12',
                'discount' => '20',
                'is_active' => true
            ]
        ];

        foreach ($packages as $package) {
            Package::create([
                'id' => $package['id'],
                'color' => $package['color'],
                'price' => $package['price'],
                'duration' => $package['duration'],
                'discount' => $package['discount'],
                'is_active' => $package['is_active']
            ]);
        }


        $package_translation = [
            [
                'id' => '3cfb9746-2yd9-4lj-8371-12178c9fca53',
                'package_id' => '3cfb9746-9779-4lj-8371-12545c9fca53',
                'name' => 'اساسية',
                'description' => 'وصف البطاقة الاساسية',
                'locale' => 'ar',
            ],
            [
                'id' => '3cfb9746-9779-4lj-8371-12178c9fca53',
                'package_id' => '3cfb9746-9779-4lj-8371-12545c9fca53',
                'name' => 'Basic',
                'description' => 'basic package description',
                'locale' => 'en',
            ],

            [
                'id' => '3cfb9746-31p9-4lj-1478-12178c9fca53',
                'package_id' => '3cfb9746-9779-4lj-8371-5fjk35c9fca53',
                'name' => 'ذهبية',
                'description' => 'وصف البطاقة الذهبية',
                'locale' => 'ar',
            ],
            [
                'id' => '3cfb9746-1188-4lj-8371-12178c9fca53',
                'package_id' => '3cfb9746-9779-4lj-8371-5fjk35c9fca53',
                'name' => 'Gold',
                'description' => 'gold package description',
                'locale' => 'en',
            ],

            [
                'id' => '3cfb9746-fdg5-4lj-8371-12178c9fca53',
                'package_id' => '3cfb9746-9779-4lj-6688-12545c3hca53',
                'name' => 'بلاتينية',
                'description' => 'وصف البطاقة البلاتينية',
                'locale' => 'ar',
            ],
            [
                'id' => '3cfb9746-1358-4lj-8371-12178c9fca53',
                'package_id' => '3cfb9746-9779-4lj-6688-12545c3hca53',
                'name' => 'Platinum',
                'description' => 'platinum package description',
                'locale' => 'en',
            ],

        ];

        foreach ($package_translation as $package) {
            PackageTranslation::create([
                'id' => $package['id'],
                'package_id' => $package['package_id'],
                'name' => $package['name'],
                'description' => $package['description'],
                'locale' => $package['locale'],
            ]);
        }


    }

}
