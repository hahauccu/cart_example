<?php
namespace App\Repositories;
use App\Models\CheckOut;

class CartRepository 
{
    protected $checkOut ;


    public function __construct(CheckOut $checkOut )
    {
        $this->checkOut = $checkOut;
    }

    public function saveCheckOut($checkOutData)
    {
      $random_id=$checkOutData["random_id"];
      $checkOut = new $this->checkOut;
      foreach ($checkOutData as $key => $value) 
      {
        $checkOut->$key=$value;
      }
      $checkOut->save();

      return $this->checkOut::where("random_id",$random_id)->first()->id;
    }
    public function getcart($cartCode)
    {
      $cart = $this->cart::where("cart_code",$cartCode)->first();
      if(!empty($cart))
      {
        $cart = $cart->toArray();
      }
      return $cart;

    }

}