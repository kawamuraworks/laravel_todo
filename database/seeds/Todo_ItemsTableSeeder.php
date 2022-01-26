<?php

use Illuminate\Database\Seeder;

class Todo_ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'item_name' => 'テスト',
            'registration_date' => '2022/01/25',
            'expire_date' => '2022/02/4',
            'finished_date' => '2022/02/01',
            'is_deleted' => '0',
        ];
        DB::table('todo_items')->insert($param);
    }
}
