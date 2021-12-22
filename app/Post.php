<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
   protected $table = 'posts';
   protected $fillable = ['title', 'content', 'image', 'post_category_id'];

   public function category()
   {
      return $this->belongsTo(PostCategory::class, 'post_category_id');
   }

   public function getSlugAttribute()
   {
      return Str::slug($this->title);
   }

}