<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category_product';
    protected $fillable = [
        'category_name', 'category_description', 'category_parent', 'category_thumb', 'category_active',
    ];

}
