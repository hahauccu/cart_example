<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;
    protected $table = 'check_out';

    public function productContent()
    {
        return $this->hasMany('App\Models\PurchasedProductList',"check_out_id","random_id");
    }

    public function discountContent()
    {
        return $this->hasOne('App\Models\Discount',"id","discount_id");
    }
}
