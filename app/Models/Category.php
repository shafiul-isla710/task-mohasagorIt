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
    ];

    public function subCategories():HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

}
