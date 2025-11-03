<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategory extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'image',
        'status',
        'meta_title',
        'meta_description',
        'meta_key',
        'meta_content',
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
