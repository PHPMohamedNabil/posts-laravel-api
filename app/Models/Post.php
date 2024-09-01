<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

   protected $fillable =  ['title','body','cover_image','pinned'];
   protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Tag()
    {
           return $this->belongsToMany(
        Tag::class,
        'posts_tags',
        'post_id',
        'tag_id');
    }

}
