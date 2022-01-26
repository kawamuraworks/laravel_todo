<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'family_name' => '山田',
            'first_name' => '太郎',
            'email' => 'taro@yamada.jp',
            'password' => 'test1234',
            'is_admin' => '1',
            'is_deleted' => '0',
        ];
        DB::table('users')->insert($param);

        $param = [
            'family_name' => '鈴木',
            'first_name' => '一郎',
            'email' => 'ichiro@suzuki.com',
            'password' => 'test1234',
            'is_admin' => '0',
            'is_deleted' => '0',
        ];
        DB::table('users')->insert($param);

        $param = [
            'family_name' => '佐藤',
            'first_name' => '二郎',
            'email' => 'jiro@sato.com',
            'password' => 'test1234',
            'is_admin' => '0',
            'is_deleted' => '1',
        ];
        DB::table('users')->insert($param);

    }


}
