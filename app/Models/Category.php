<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'parent_id', 'image', 'tags', 'description', 'seo_title', 'seo_description'];
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s'];
    
    public function parents () {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function posts () {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
