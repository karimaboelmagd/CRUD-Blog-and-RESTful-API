<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected mixed $category_id;
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
