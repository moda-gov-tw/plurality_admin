<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->data();

        foreach ($data as $value) {
            if($value['name'] == 'editor'){
                $role = Role::create([
                    'name' => $value['name'],
                    'chinese_name' => $value['chinese_name'],
                ]);

                $role->givePermissionTo('create news');
                $role->givePermissionTo('update news');
                $role->givePermissionTo('read news');
                $role->givePermissionTo('delete news');

                $role->givePermissionTo('create exhibition');
                $role->givePermissionTo('update exhibition');
                $role->givePermissionTo('read exhibition');
                $role->givePermissionTo('delete exhibition');


            }
            else{//admin
                $role = Role::create([
                    'name' => $value['name'],
                    'chinese_name' => $value['chinese_name'],
                ]);

                $role->givePermissionTo('create user');
                $role->givePermissionTo('update user');
                $role->givePermissionTo('read user');
                $role->givePermissionTo('delete user');

                $role->givePermissionTo('create news');
                $role->givePermissionTo('update news');
                $role->givePermissionTo('read news');
                $role->givePermissionTo('delete news');

                $role->givePermissionTo('create exhibition');
                $role->givePermissionTo('update exhibition');
                $role->givePermissionTo('read exhibition');
                $role->givePermissionTo('delete exhibition');

                
                //role 只有讀取、更新及新增
                $role->givePermissionTo('create role');
                $role->givePermissionTo('update role');
                $role->givePermissionTo('read role');
                // $role->givePermissionTo('delete role');

                

            }
            
        }
    }

    public function data()
    {
        return [
            ['name' => 'admin','chinese_name' => '管理員'],
            ['name' => 'editor','chinese_name' => '編輯'],
        ];
    }
}
