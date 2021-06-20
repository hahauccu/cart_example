<?php
namespace App\Repositories;
//Models
use App\Models\CheckOut;



class OrderRepository 
{
    protected $checkOut;
    protected $purchasedProductList;


    public function __construct(CheckOut $checkOut)
    {
        $this->checkOut = $checkOut;
    }

    public function get($user_id)
    {
      $orderData = $this->checkOut::where("user_id",$user_id)->get();
      if(!empty($orderData))
      {
        $orderData = $orderData->toArray();
      }
      return $orderData;
    }

    public function getCheckoutWithDiscount($random_id)
    {
      return $this->checkOut::where("random_id",$random_id)->with("productContent","discountContent")->first();
    }


}