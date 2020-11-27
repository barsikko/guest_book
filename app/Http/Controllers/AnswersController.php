<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\AnswerPost;


class AnswersController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, AnswerPost $request)
    {

        //$id = $request->post;
          $post = $post::findOrFail($request->get('post'));
          $page = $request->page;

           // $answers = $post->anserAnswer::all()->count();
        $posts_count = $post->answers()->get()->count();
        
        if ($posts_count < 1) {
          $validatedData = $request->validated();
          $validatedData['user_id'] = $request->user()->id;

          $post->answers()->create($validatedData);
            $request->session()->flash('status', 'Ответ добавлен'); 
          } else {
            $request->session()->flash('error', 'Ошибка у вас уже есть ответ');
          }

          return redirect()->route('posts.index', ['page' => $page]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerPost $request, $id)
    {
            //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
