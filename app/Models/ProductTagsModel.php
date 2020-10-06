<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTagsModel extends Model
{
    use HasFactory;
    protected $table = 'product_tags';
    protected $fillable = [
        'tag_id', 'product_id'
    ];
}
