<?php

use Illuminate\Database\Seeder;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        $posts = App\Post::all();

        $posts_count = $posts->count();

        factory(App\Answer::class, $posts_count)->make()->each( function($answer) use($users, $posts) {
				$answer->user_id = $users->random()->id;
            	$answer->post_id = $posts->random()->id; 
            //	foreach ($posts as $post){
            //		if ($answer->post_id !== $post->id)		
        			$answer->save();
        	//	}	
        });
    }
}
