<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
        // $this->middleware('post.user')->except('index','show','create','store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('published',true)
        ->where('published_at','<=',now())
        ->orderByDesc('created_at')
        ->paginate(5);
        return view('blogs.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'title'         => 'required|min:2|max:100',
            'body'          => 'required|min:2',
            'published_at'  => 'required|date',
            'published'     => 'required'
        ]);
        Post::create([
            'user_id'       => auth()->id(),
            'title'         => $request->title,
            'body'          => $request->body,
            'published_at'  => $request->published_at,
            'published'     => $request->published
        ]);

        return redirect(route('blogs.index'));
    }

    /**
     * Display the specified resource.
     *s
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findorFail($id);
        return view('blogs.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findorFail($id);
        if ($post->user_id !== auth()->id()) {
            abort(404);
        }else{
            return view('blogs.edit',compact('post'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|min:2|max:100',
            'body'          => 'required|min:2',
            'published_at'  => 'required|date',
            'published'     => 'required'
        ]);
        $post = Post::findorFail($id);
        $post->update([
            'title'         => $request->title,
            'body'          => $request->body,
            'published_at'  => $request->published_at,
            'published'     => $request->published
        ]);

        return redirect(route('blogs.show',['blog' => $post->id]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findorFail($id);
        if (auth()->id() == $post->user_id) {
            $post->delete();
            return redirect(route('blogs.index'));
        }

    }
}
