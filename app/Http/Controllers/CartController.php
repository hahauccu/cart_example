<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//models
use App\Models\ProductList;
use App\Models\Discount;
use App\Models\PurchasedProductList;
use App\Models\CheckOut;

//Repository
use App\Repositories\ProductRepository;
use App\Repositories\DisCountRepository;
use App\Repositories\CartRepository;

//Service
use App\Service\CartService;

class CartController 
{
	
	protected $cartService;
	protected $cartRepository;
	protected $productRepository;
	protected $discountRepository;

	function __construct(ProductRepository $productRepository,CartService $cartService,DiscountRepository $discountRepository,CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->discountRepository = $discountRepository;
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
    }


	public function addToCart(Request $request)
	{
		$message="";
		$toAddCartId=$_POST["product_id"];
   		//get user cart data
		$cartData = $request->session()->get("cartData");

		$cartData = $this->cartService->checkCartData($cartData,$toAddCartId);

		$request->session()->put("cartData",$cartData["cartData"]);
		return $cartData["message"];
	}

	public function showList(Request $request)
	{
		$cartData = $request->session()->get("cartData");

		$discountCode = $request->session()->get("discountCode");
		if(empty($cartData))
		{
			return redirect("product/list")->with('message', '購物車沒有商品');   ;
		}
		$cartList = $this->cartService->generateCartList($cartData,$discountCode);
		//discount calculation
		$discount = array();

		// if stock not enough
		if(!empty($cartList["message"]))
		{
			$request->session()->flash('message', $message);

			$request->session()->put('cartData', $cartList["cartData"]);

			if(empty($cartList["cartData"]))
			{
				return redirect("product/list")->with('message', $message.'\n購物車沒有商品');   ;
			}
		}
		return view("cart_list",
        [
            "productData" =>$cartList["productData"],
            "orderPrice" =>$cartList["orderPrice"],
            "discount" => $cartList["discount"]
        ]);
	}

	// public function checkOut($cartData,$productData,$toSearchProduct,$discountCode="")
	// {
	// 	$orderPrice = 0;
	// 	$stockArray =$this->productRepository->checkStock($toSearchProduct);
	// 	$message = "";
	// 	foreach ($productData as $key => $value) 
	// 	{
	// 		if($cartData[$value["id"]]> $value["stock"])
	// 		{
	// 			$message .=$value["product_name"]."庫存不足 已移出購物車請重新購買<br>";
	// 			unset($productData[$key]);
	// 			unset($cartData[$value["id"]]);
				
	// 			continue;
	// 		}

	// 		$sell_product_number = $cartData[$value["id"]];

	// 		$productData[$key]["in_cart"] = $sell_product_number;
	// 		$productData[$key]["in_cart_price"] = $value["price"] * $sell_product_number;
	// 		$orderPrice+=$productData[$key]["in_cart_price"];
	// 	}

	// 	$discount=array();
	// 	if(!empty($discountCode))
	// 	{
	// 		$discount = Discount::where("discount_code",$discountCode)->first()->toArray();
	// 		//if is fit the condition
	// 		if($orderPrice >= $discount['price_condition'])
	// 		{
	// 			//type to calculation the check out price
	// 			switch ($discount["type"]) {
	// 				case 1:
	// 					$orderPrice*=$discount["price"];
	// 					break;
	// 				case 2:
	// 					$orderPrice-=$discount["price"];
	// 					break;
	// 				default:
	// 					# code...
	// 					break;
	// 			}
	// 		}
	// 	}
	// 	// if stock not enough
	// 	if(!empty($cartList["message"]))
	// 	{
	// 		$request->session()->flash('message', $cartList["message"]);

	// 		$request->session()->put('cartData', $cartList["cartData"]);
	// 		if(empty($cartList["cartData"]))
	// 		{
	// 			return redirect("product/list")->with('message', $cartList["message"].'\n購物車沒有商品');   ;
	// 		}
	// 	}
	// 	return ["productData" => $productData,
	// 			"orderPrice"=>$orderPrice,
	// 			"message"=>$message,
	// 			"cartData" =>$cartData,
	// 			"discount" =>$discount,
	// 			];
	// }

	public function removeProduct(Request $request)
	{
		$toRemoveProductId = $_POST["product_id"];
		$cartData = $request->session()->get("cartData");
		unset($cartData[$toRemoveProductId]);
		$request->session()->put("cartData",$cartData);
		return 1;
	}


	
	public function minusToCart(Request $request)
	{
		$toMinusCartId=$_POST["product_id"];
   		//get user cart data
		$cartData = $request->session()->get("cartData");
		$cartData[$toMinusCartId]-=1;

		if($cartData[$toMinusCartId] == 0)
		{
			unset($cartData[$toMinusCartId]);
		}
		
		$request->session()->put("cartData",$cartData);
	}

	public function addDiscountCode(Request $request)
	{
		$message="discount code not exist";
		$toAddCode = $_POST["to_add_code"];
		$discountCodeData= $this->discountRepository->getDiscount($toAddCode);
		if(!empty($discountCodeData))
		{
			$request->session()->put("discountCode",$toAddCode);
			$message = "use dicount code success";
		}
		return $message;

	}

	public function saveCheckOut(Request $request)
	{
		$cartData = $request->session()->get("cartData");

		$discountCode = $request->session()->get("discountCode");
		if(empty($cartData))
		{
			return redirect("product/list")->with('message', '購物車沒有商品');   ;
		}
		$cartList = $this->cartService->generateCartList($cartData,$discountCode);

		//save check out data
		$random_id = time().$this->cartService->getRamdomString(8);
		$toSaveCheckOut = 
		array(
			"user_id"=>1,
			"random_id"=>$random_id,
			"recive_price"=>$cartList["orderPrice"]
		);

		//if discount
		if(!empty($cartList["discount"]))
		{
			$toSaveCheckOut["discount_id"]=$cartList["discount"]["id"];
		}

		$checkOutId = $this->cartRepository->saveCheckOut($toSaveCheckOut);
		
		
		foreach ($cartList["cartData"] as $key => $value) 
		{
			//insert sold product
			$purchasedProductList = new PurchasedProductList;
			$purchasedProductList->product_id=$key;
			$purchasedProductList->purchased_number=$value;
			$purchasedProductList->check_out_id=$random_id;
			$purchasedProductList->save();

			// update product stock
			$tmepProductData = ProductList::where("id",$key)->first();
			$tmepProductData->stock-=$value;
			$tmepProductData->save();

		}
		//clean session
		$request->session()->forget('cartData');
		$request->session()->forget('discountCode');
		return $random_id;
	}	
}
