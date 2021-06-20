<?php
namespace App\Service;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;


class OrderService
{
	protected $orderRepository;
	public function __construct(OrderRepository $orderRepository,ProductRepository $productRepository)
	{
		$this->orderRepository = $orderRepository;
		$this->productRepository = $productRepository;

	}


	public function getOrderDetailData($random_id)
	{
		$ProductList = $this->productRepository->get();
		$ProductListArray = array();
		foreach ($ProductList as $key => $value) 
		{
			$ProductListArray[$value["id"]] = $value;
		}

		$orderData = $this->orderRepository->getCheckoutWithDiscount($random_id);
		if(!empty($orderData))
		{
			$orderData = $orderData->toArray();
		}

		foreach ($orderData["product_content"] as $key => $value) 
		{
			$ProductListArray[$value['product_id']]["purchased_number"]=$value["purchased_number"];
			$orderData["product_content"][$key]=$ProductListArray[$value['product_id']];
		}
		return $orderData;
	}
}