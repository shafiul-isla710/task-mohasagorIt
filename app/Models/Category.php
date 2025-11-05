<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
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

    public function subCategories():HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
    public function subSubCategories():HasMany
    {
        return $this->hasMany(SubSubCategory::class);
    }

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
