<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//        $this->call(UserNameSeeder::class);
//        $this->call(CreateContactsTable::class);
        $this->call(UsersTableSeeder::class);
        $this->call(blogTableSeeder::class);
    }
}
