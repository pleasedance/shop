<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([
            'company_id' => '1',
            'name' => '觅集',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('company_user')->insert([
            'username' => 'admin',
            'password' => 'e10adc3949ba59abbe56e057f20f883e',
            'loginid' => 'admin',
            'email' => '',
            'company_id' => '1',
            'role_id' => '0',
            'role_name' => 'root',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('seller')->insert([
            'seller_id' => '1',
            'real_name' => '觅集',
            'province' => '浙江省',
            'city' => '杭州市',
            'area' => '江干区',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('seller_user')->insert([
            'seller_id' => '1',
            'real_name' => '觅集',
            'password' => 'e10adc3949ba59abbe56e057f20f883e',
            'loginid' => 'miji',
            'phone' => '110',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('system_user')->insert([
            'id' => '1',
            'loginid' => 'admin',
            'password' => 'e10adc3949ba59abbe56e057f20f883e',
            'role_id' => '0',
            'role_name' => 'root',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
