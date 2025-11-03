<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = ['name','attribute_id','status'];

    protected $hidden = ['created_at', 'updated_at'];
    public function attribute(){
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
