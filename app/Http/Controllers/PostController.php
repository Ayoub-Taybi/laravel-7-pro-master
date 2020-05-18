<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


// use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show','allPost','archive']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        return view(
            'posts.index', 
            ['posts' => Post::withCount('comments')->orderBy('updated_at','desc')->get(),'tab'=>'list']
        );
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
     

        return view(
            'posts.index', 
            ['posts' => Post::onlyTrashed()->withCount('comments')->orderBy('updated_at','desc')->get(),'tab'=>'archive']
        );
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allPost()
    {
     
        return view(
            'posts.index', 
            ['posts' => Post::withTrashed()->withCount('comments')->orderBy('updated_at','desc')->get(),'tab'=>'all']
        );
    }



    

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       // dd(Post::with('comments')->findOrFail($id));
        return view('posts.show', [
            'post' => Post::withTrashed()->with('comments')->findOrFail($id)
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {

      

        $validatedData = $request->validated();

        $validatedData['user_id'] = Auth::id();

        $Post = Post::create($validatedData);

        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $Post->id]);


    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if(Gate::denies('post-update',$post)){


            abort(403,"you can edit this post !!");


        };


        return view('posts.edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id)
    {
        $post = Post::findOrFail($id);
        
        
        if(Gate::denies('post-update',$post)){


            abort(403,"you can edit this post !!");


        };
        
        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);


        $this->authorize("post-delete",$post);


        $post->delete();

        // Post::destroy($id);

        $request->session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }


    public function restore($id)
    {

    
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->back();

        
    }


    public function forcedelete($id)
    {
    
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->comments()->forceDelete();

        $post->forceDelete();

        return redirect()->back();
        
    }



}
