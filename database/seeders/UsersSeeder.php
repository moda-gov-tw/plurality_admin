<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\UserInfo;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $demoUser = AdminUser::create([
            'name'              => '測試用1',
            'email'             => 'demo@demo.com',
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'api_token'         => Hash::make('demo@demo'),
        ]);

        $demoUser->syncRoles('admin');
        $this->addDummyInfo($faker, $demoUser);

        $demoUser2 = AdminUser::create([
            'name'              => '測試用2',
            'email'             => 'admin@demo.com',
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
            'api_token'         => Hash::make('admin@demo'),
        ]);

        $demoUser2->syncRoles('editor');

        $this->addDummyInfo($faker, $demoUser2);

        // AdminUser::factory(100)->create()->each(function (AdminUser $user) use ($faker) {
        //     $this->addDummyInfo($faker, $user);
        // });
    }

    private function addDummyInfo(Generator $faker, AdminUser $user)
    {
        $dummyInfo = [
            'company'  => $faker->company,
            'phone'    => $faker->phoneNumber,
            'website'  => $faker->url,
            'language' => $faker->languageCode,
            'country'  => $faker->countryCode,
        ];

        $info = new UserInfo();
        foreach ($dummyInfo as $key => $value) {
            $info->$key = $value;
        }
        $info->user()->associate($user);
        $info->save();
    }

    
}
