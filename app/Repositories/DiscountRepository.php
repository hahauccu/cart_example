<?php
namespace App\Repositories;
use App\Models\Discount;


class DiscountRepository 
{
    protected $discount;


    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
       
    }


    public function getDiscount($discountCode)
    {
      $discount = $this->discount::where("discount_code",$discountCode)->first();
      if(!empty($discount))
      {
        $discount = $discount->toArray();
      }
      return $discount;

    }

}