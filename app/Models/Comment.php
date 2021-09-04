<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Table of model
     * 
     * @return string
     */
    protected $table = 'comments';
    
    /**
     * Fillable table 
     * 
     * @return array
     */
    protected $fillabel = ['comments', 'comment_id', 'author'];
}
