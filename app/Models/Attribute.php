<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    protected $fillable = ['name','status'];

    public $hidden = ['created_at', 'updated_at'];

    public function variants():HasMany
    {
        return $this->hasMany(Variant::class, 'attribute_id');
    }
}
