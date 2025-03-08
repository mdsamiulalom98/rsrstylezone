<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model
{
   protected $table = 'campaign_products';
    use HasFactory;
    
    public function product()
    {
        // Assuming one-to-one relationship
        // return $this->hasOne(Product::class, 'foreign_key', 'local_key');

        // Assuming one-to-many relationship
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
