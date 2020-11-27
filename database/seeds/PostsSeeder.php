<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = App\User::all();

        factory(App\Post::class, 5)->make()->each( function($post) use($users) {
        	$post->user_id = $users->random()->id;
        	$post->save();
        });
    }
}
