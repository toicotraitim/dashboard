<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;
    protected $table = "menus";
    protected $fillable  = [
        'menu_name', 'menu_description', 'menu_parent', 'menu_icon', 'menu_active', 'menu_slug'
    ];
    
}
