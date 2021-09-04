<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;
    
    public static $snakeAttributes = true;

    /**
     * Table of model
     * 
     * @return string
     */
    protected $table = 'posts';

    /**
     * Fillable table 
     * 
     * @return array
     */
    protected $fillable = ['name', 'slug', 'status', 'description', 'category_id', 'content', 'seo_title', 'seo_description', 'tags', 'author', 'like', 'view', 'image'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    /**
     * category relationship
     * 
     * @return array
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * author relationship
     * 
     * @return array
     */
    public function user(){
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
