<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    
    public function article(){
        return $this->belongsToMany(Article::class, 'article_tag', 'tag_id', 'article_id')->withTimestamps();
    }
}
