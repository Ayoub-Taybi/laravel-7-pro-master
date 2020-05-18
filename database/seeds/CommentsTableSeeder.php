<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts=App\Post::all();


        $numberComments =(int)$this->command->ask("How maney of comments you want to generate",30);


        if($posts->count()==0){

            $this->command->info('Please create some posts first -_-');
            return;
        }
        
        
        factory(App\Comment::class,$numberComments)->make()->each(function($comment) use ($posts){

            $comment->post_id =  $posts->random()->id;

            $comment->save();


        });
    }
}
