<?php

namespace App\Http\Controllers;

use Auth;
use App\Comments;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Posts $post)
    {
        return response()->json([
            'comments' => Comments::where('post_id',$post->id)->orderBy('created_at', 'desc')->paginate(5)
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
    public function store(CommentRequest $request,Posts $post)
    {
        $this->authorize('create',Comments::class);
        $request->validated();
        
        return response()->json([
            'comment' => Comments::create([
                'comment' => $request->comment,
                'image' => isset($request->image) ? $request->image->store('comments') : null,
                'post_id' => $post->id,
                'user_id' => Auth::user()->id
            ])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request,Posts $post,Comments $comment)
    {
        $this->authorize('update',$comment);
        $request->validated();
        

        if($request->image){
            $comment->image = $request->image;
        }

        $comment->update([
            'comment' => $request->comment
        ]);

        return response()->json([
            'comment' => $comment,
            //'image' => isset($request->image) ? $request->image->store('comments') : 'images/'.$request->image,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $post,Comments $comment)
    {
        $this->authorize('delete',$comment);
        $comment->delete();
    }
}
