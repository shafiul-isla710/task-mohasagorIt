<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'sub_category_id',
        'status',
        'discount',
        'meta_title',
        'meta_description',
        'meta_key',
        'meta_content',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
