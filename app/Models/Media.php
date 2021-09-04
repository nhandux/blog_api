<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * Table of model
     * 
     * @return string
     */
    protected $table = 'medias';
    
    /**
     * Fillable table 
     * 
     * @return array
     */
    protected $fillable = ['name', 'file', 'type', 'seo_title', 'seo_desription', 'like', 'view'];
}
