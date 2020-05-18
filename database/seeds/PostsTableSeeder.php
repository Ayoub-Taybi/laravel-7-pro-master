<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users=App\User::all();


        if($users->count()==0){

            $this->command->info('Please create some users first -_-');
            return;
        }

        $numberPosts =(int)$this->command->ask("How maney of posts you want generate",30);

        factory(App\Post::class,$numberPosts)->make()->each(function($post) use ($users){

            $post->user_id =  $users->random()->id;

            $post->save();


        });
    }
}
