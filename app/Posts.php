<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    public $table = 'posts';

    protected $fillable = ['title','body', 'user_id','image'];
    
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function comments(){
        return $this->hasMany(Comments::class,'post_id');
    }

    public function likes(){
        return $this->hasMany(Like::class,'post_id');
    }
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
    
    public function removeLike(){
        $this->likes->where('user_id',auth()->user()->id)->first()->delete();
    }
    
    public function isLikedBy(User $user){
        return (bool) $user->likes->where('user_id',$user->id)->where('liked',true)->count();
    }


    public function getImageAttribute($value){
        return asset('storage/'.$value) ;
    }
}
