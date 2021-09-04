<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    use HasFactory;

    /**
     * Table of model
     * 
     * @return string
     */
    protected $table = 'constants';
    
    /**
     * Fillable table 
     * 
     * @return array
     */
    protected $fillabel = ['name', 'value'];
}
