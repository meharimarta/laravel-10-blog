<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('users')->insert([
            'name'=>'Protech','password'=>HASH::make('123456789'),
            'email'=>'protech@founder.GtM',
            'email_verified_at'=>$now,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('users')->insert([
            'name'=>'Anonymous',
            'password'=>HASH::make('/*anonymous(123456789)*/'),
            'email'=>'anonymous@gmail.com',
            'email_verified_at'=>$now,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
