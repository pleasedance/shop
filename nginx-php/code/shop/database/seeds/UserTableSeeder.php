<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //填充数据测试
        factory(App\Models\UserModel::class,1000)->create()->each(function($u){
            //$u->posts()->save(factory(App\Post::class)->make());
        });
    }
}
