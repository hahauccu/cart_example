<?php
namespace App\Service;
use App\Repositories\DiscountRepository;


class DiscountService
{
	protected $discountRepository;
	public function __construct(DiscountRepository $discountRepository)
	{
		$this->discountRepository = $discountRepository;
	}

	public function calculatDiscount($discountCode,$orderPrice)
	{
		$discount = $this->discountRepository->getDiscount($discountCode);

			//if is fit the condition
			if($orderPrice >= $discount['price_condition'])
			{
				//type to calculation the check out price
				switch ($discount["type"]) {
					case 1:
						$orderPrice*=$discount["price"];
						break;
					case 2:
						$orderPrice-=$discount["price"];
						break;
					default:
						# code...
						break;
				}
			}
			return array("discount"=>$discount,"orderPrice" =>$orderPrice);
	}
}