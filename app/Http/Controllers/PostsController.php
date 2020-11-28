<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Answer;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PostsController extends Controller
{

        public function __construct()
    {

        $this->middleware('auth')->except('index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;

        $posts = Post::paginate(25, ['*'], 'page', $page);

        return view('index', [
            'posts' => $posts
        ]);
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
    public function store(StorePost $request)
    {
        $valid = $request->validated();
        $valid['user_id'] = $request->user()->id;

        $post = Post::create($valid);
       
        if ($request->hasFile('thumbnail')){
             $file = $request->file('thumbnail');
                
                $path = public_path('storage/thumbnails');
  
                    $validateImage = Validator::make($request->all(), [
              'thumbnail' => 'dimensions:min_width=100,min_height=100,max_width=500,max_height=500'
                     ])->passes();

                if ( !$validateImage )
                {
                    $resizable = Image::make($file->getRealPath());
                    $resizable->resize(500, 100, function($constraint){
                        $constraint->aspectRatio();
                    })->save($path. '/'.$post->id.'.'.$file->guessExtension());       
                } else {
             $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());
            }
        }
      
        return response()->json(/*['status' => 'Добавлено']*/);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $page = $request->page;

        $posts = Post::paginate(25);

        $post = Post::findOrFail($id);
   
            $this->authorize($post);

        return view('index', ['posts' => $posts, 'edit' => $post, 'page' => $page]);
        //return redirect()->route('posts.index', ['edit' => $post, 'page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = Post::findOrFail($id);

        $valid = $request->validated();
        $page = $request->page;

        if($post->answers()->get()->count() < 1)
        {
        $post->content = $valid['content']; 
        $post->save();

        $request->session()->flash('status', 'Запись была обновлена');        
        } else {
        $request->session()->flash('error', 'Ошибка обновления записи на этот пост уже есть ответ');           
          }

        return redirect()->route('posts.index', ['page' => $page]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
