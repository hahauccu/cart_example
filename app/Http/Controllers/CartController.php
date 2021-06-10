<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//models
use App\Models\ProductList;

//Repository
use App\Repositories\ProductRepository;

class CartController 
{
	protected $productRepository;

	function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
	public function addToCart(Request $request)
	{
		$message="";
		$toAddCartId=$_POST["product_id"];
   		//get user cart data
		$cartData = $request->session()->get("cartData");
   		//if cart is empty than add one to array
		if(empty($cartData))
		{
			$cartData = array($toAddCartId=>1);
			$message = "加入購物車成功";
		}
		//check if sold out 
		else
		{
			$stock = $this->productRepository->checkStock($toAddCartId);

			if(empty($cartData[$toAddCartId]))
			{
				$cartData[$toAddCartId] = 0;
			}
			if($stock  < $cartData[$toAddCartId]+1 )
			{
				$message = "庫存不足";
				return $message;
			}
			else
			{
				$cartData[$toAddCartId]+=1;
				$message = "加入購物車成功";
			}
		}
		$request->session()->put("cartData",$cartData);
		return $message;
	}
}
