<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $fillable = [
        'title', 'status', 'text_content', 'user_id',
    ];

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
