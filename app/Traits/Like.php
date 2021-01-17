<?php

namespace App\Traits;
use App\User;

trait Like
{
    public function like($user = null, $liked = true){
        $this->likes()->updateOrCreate( 
            ['user_id' => $user ? $user->id : auth()->user()->id ], 

            [
            'user_id' => $user ? $user->id : auth()->user()->id ,
            'liked' => $liked
            ]
        );
    }
    public function dislike($user = null,$liked = false){
        $this->like($user,$liked);
    }
    
    public function removeLike(){//removeLikeDislike
        $this->likes->where('user_id',auth()->user()->id)->first()->delete();
    }
    
    public function isLikedBy(User $user){
        return (bool) $user->likes->where('user_id',$user->id)->where('liked',true)->count();
    }
    //add count likes for post

    public function getImageAttribute($value){
        return asset('storage/'.$value) ;
    }
}