<?php

namespace App;

use Auth;
use App\Traits\Like;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use Like;

    public $table = 'posts';

    protected $fillable = ['title','body', 'user_id','image'];
    
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function comments(){
    return $this->hasMany(Comments::class,'post_id');
    }

    public function likes(){
        return $this->hasMany('App\Like','post_id');
    }
}
