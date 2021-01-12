<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = ['user_id','post_id','comment','image'];

    public function user(){//commentOwner
    return $this->belongsTo(User::class/*,'user_id'*/);
    }
    public function post(){
    return $this->belongsTo(Posts::class/*,'post_id'*/);
    }
}
