<?php

namespace App\Http\Controllers;

use Auth;
use App\Like;
use App\Posts;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Posts $post)
    {
        return response()->json([
            'likes' => Like::where('post_id',$post->id)->where('liked',1)->paginate(15)
        ]);
    }

    public function store(Posts $post){
        $post->like();
    }

    public function destroy(Posts $post){
        $post->unlike();
    }
}
