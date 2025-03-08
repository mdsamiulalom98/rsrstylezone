<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function childcategories() {
        return $this->hasMany(Childcategory::class, 'subcategory_id');
    }
    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
