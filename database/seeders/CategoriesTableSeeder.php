<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Categories')->insert(['category'=>'Technology','user_id'=>0]);
        DB::table('Categories')->insert(['category'=>'Art']);
        DB::table('Categories')->insert(['category'=>'Promotion']);
    }
}
