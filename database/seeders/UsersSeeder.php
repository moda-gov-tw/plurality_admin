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
        

        $demoUser1 = AdminUser::create([
            'name'              => '彼峰管理者',
            'email'             => 'ryanhu1208@gmail.com',
            'email_verified_at' => now(),
            'token'         => Hash::make('ryanhu1208@gmail.com'),
        ]);

        $demoUser1->syncRoles('admin');

        $this->addDummyInfo($faker, $demoUser1);

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
