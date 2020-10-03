<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;
    protected $table = 'post_product';
    protected $fillable = [
        'post_name', 'post_description', 'category', 'post_images', 'post_active',
    ];
}
