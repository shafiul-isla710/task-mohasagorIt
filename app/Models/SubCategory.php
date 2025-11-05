<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    protected $hidden = [
        'created_at',
        'updated_at',
        'image',
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    // image url generate
    protected $appends = ['image_url'];
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }
}
