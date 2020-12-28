<?php

namespace App\Http\Controllers;


use Auth;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'posts' => Posts::with('comments')->orderBy('created_at', 'desc')->paginate(5)
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
    public function store(PostRequest $request) //dodati form req check opcijonalno slika ili tekst ili oboje
    {
        $this->authorize('create',Posts::class);
        $request->validated();

        return response()->json([
            'post' => Posts::create([
                'title' => $request->title,
                'body' => $request->body,
                'user_id' => Auth::user()->id,
                'image' => isset($request->image) ? $request->image->store('images') : null
            ])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $post)
    {
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Posts $post) 
    {
        
        $this->authorize('update',$post);
        $request->validated();
        
        if($request->image){
            $post->image = $request->image;
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            //'image' => isset($request->image) ? $request->image->store('images') : 'images/'.$request->image // ovim načinom očekujem $request->image sa frontenda , dali je ovo ok?
        ]);
        
        return response()->json([
            'post' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $post)
    {
        $this->authorize('delete',$post);
        if($post->delete()) return response()->json(['post' => $post]);
    }
}
