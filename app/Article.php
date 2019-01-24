<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'body', 'photo'];

    public function tag(){
        return $this->belongsToMany(Tag::class, 'article_tag', 'tag_id', 'article_id')->withTimestamps();
    }
}
