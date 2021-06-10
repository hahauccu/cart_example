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

	public function showList(Request $request)
	{
		$cartData = $request->session()->get("cartData");
		$toSearchProduct = array_keys($cartData);
		$productData = $this->productRepository->getProductData($toSearchProduct);
		$cartList = $this->checkOut($cartData,$productData,$toSearchProduct);
		return view("cart_list",
        [
            "productData" =>$cartList["productData"],
            "orderPrice" =>$cartList["orderPrice"],
            "message" =>$cartList["message"]
        ]);
	}

	public function checkOut($cartData,$productData,$toSearchProduct)
	{
		$orderPrice = 0;
		$stockArray =$this->productRepository->checkStock($toSearchProduct);
		$message = "";
		foreach ($productData as $key => $value) 
		{
			if($cartData[$value["id"]]> $value["stock"])
			{
				$message .=$value["product_name"]."庫存不足 已移出購物車請重新購買<br>";
				unset($productData[$key]);
				continue;
			}

			$sell_product_number = $cartData[$value["id"]];

			$productData[$key]["in_cart"] = $sell_product_number;
			$productData[$key]["in_cart_price"] = $value["price"] * $sell_product_number;
			$orderPrice+=$productData[$key]["in_cart_price"];
		}
		return ["productData" => $productData,
				"orderPrice"=>$orderPrice,
				"message"=>$message,
				];
	}

	public function removeProduct(Request $request)
	{
		$toRemoveProductId = $_POST["product_id"];
		$cartData = $request->session()->get("cartData");
		unset($cartData[$toRemoveProductId]);
		$request->session()->put("cartData",$cartData);
		return 1;
	}
	
}
