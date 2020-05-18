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

        $numberUsers =(int)$this->command->ask("How maney of user you want generate",10);

        factory(App\User::class,$numberUsers)->create();  

        $this->command->info("Users table seeded with ".$numberUsers." users");

    }
}
