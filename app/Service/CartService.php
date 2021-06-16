<?php
namespace App\Service;
use App\Repositories\ProductRepository;
use App\Service\DiscountService;


class CartService
{
	protected $productRepository;
	protected $discountService;

	public function __construct(ProductRepository $productRepository,DiscountService $discountService)
	{
		$this->productRepository = $productRepository;
		$this->discountService = $discountService;
		
	}

	public function checkCartData($cartData,$toAddCartId)
	{
		//if cart is empty than add one to array
		if(empty($cartData))
		{
			$cartData = array($toAddCartId=>1);
			$message = "加入購物車成功";
		}
		//check if sold out 
		else
		{
			$stock = $this->checkStock($toAddCartId);

			if(empty($cartData[$toAddCartId]))
			{
				$cartData[$toAddCartId] = 0;
			}
			if($stock  < $cartData[$toAddCartId]+1 )
			{
				$message = "庫存不足";
				return array("cartData"=>$cartData,"message"=>$message);
			}
			else
			{
				$cartData[$toAddCartId]+=1;
				$message = "加入購物車成功";
			}
		}
		return array("cartData"=>$cartData,"message"=>$message);
	}

	public function generateCartList($cartData,$discountCode)
	{
		$toSearchProduct = array_keys($cartData);
		$productData = $this->productRepository->getProductByIdArray($toSearchProduct);
		return  $this->checkOut($cartData,$productData,$toSearchProduct,$discountCode);
	}

	public function checkOut($cartData,$productData,$toSearchProduct,$discountCode)
	{
		$discount = array();
		$orderPrice = 0;
		$stockArray =$this->productRepository->checkStock($toSearchProduct);
		$message = "";
		foreach ($productData as $key => $value) 
		{
			if($cartData[$value["id"]]> $value["stock"])
			{
				$message .=$value["product_name"]."庫存不足 已移出購物車請重新購買<br>";
				unset($productData[$key]);
				unset($cartData[$value["id"]]);
				continue;
			}

			$sell_product_number = $cartData[$value["id"]];

			$productData[$key]["in_cart"] = $sell_product_number;
			$productData[$key]["in_cart_price"] = $value["price"] * $sell_product_number;
			$orderPrice+=$productData[$key]["in_cart_price"];
		}
		$calculatDiscount = array("discount"=>"","orderPrice"=>"");
		if(!empty($discountCode))
		{
			$calculatDiscount = $this->discountService->calculatDiscount($discountCode,$orderPrice);
		}

		return ["productData" => $productData,
				"orderPrice"=>$calculatDiscount["orderPrice"],
				"message"=>$message,
				"cartData" =>$cartData,
				"discount" =>$calculatDiscount["discount"],
				];
	}

	public function checkStock($productId)
	{
		if(is_array($productId))
		{
			$toReturnArray = array();
			$productsData = $this->productRepository->getProductByIdArray($productId);
			foreach ($productsData as $key => $value) 
			{
				$toReturnArray[$value["id"]] = $value["stock"];
			}
			return $toReturnArray;
		}
		else
		{
			$productsData = $this->productRepository->getProductById($productId);
			return $productsData["stock"];
		}
	}

	public function getRamdomString($randonStringLength)
	{
		$pool="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
			$toReturnString = "";
			for ($i=0; $i <$randonStringLength ; $i++) 
			{ 
				$toReturnString.=$pool[rand(0,strlen($pool))-1];
			}
		return $toReturnString;
	}
}