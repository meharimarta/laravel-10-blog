<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(['category'=>'Technology','user_id'=>'1']);
        DB::table('categories')->insert(['category'=>'Art','user_id'=>'1']);
        DB::table('categories')->insert(['category'=>'Promotion','user_id'=>'1']);
//            ->insert(['catagory'=>'Education']);
    }
}
