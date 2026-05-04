<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'app_name', 
        'school_name', 
        'logo', 
        'primary_color', 
        'secondary_color',
        'hero_badge',
        'hero_title',
        'hero_description',
        'hero_image'
    ];
}
