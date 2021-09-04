<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;
    
    /**
     * Table of model
     * 
     * @return string
     */
    protected $table = 'questions';
    
    /**
     * Fillable table 
     * 
     * @return array
     */
    protected $fillable = ['title', 'slug', 'description', 'content', 'tags', 'like', 'view', 'seo_title', 'seo_desription', 'status'];

    /**
     * Fillable table 
     * 
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }
}
