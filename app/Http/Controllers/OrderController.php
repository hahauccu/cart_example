<?php

namespace App\Http\Controllers;

//Repositories
use App\Repositories\OrderRepository;
//Service
use App\Service\OrderService;


class OrderController 
{
  protected $orderRepository;
  protected $orderService;
  function __construct(OrderRepository $orderRepository,OrderService $orderService )
  {
    $this->orderRepository = $orderRepository;
    $this->orderService = $orderService;
  }
   public function list()
   {
   	return view("order_list",
        [
            "orderData" =>$this->orderRepository->get(1)
        ]);
   }
   public function listDetail($random_id="")
   {
    return view("order_list_detail",
        [
            "orderData" =>$this->orderService->getOrderDetailData($random_id)
        ]);
    
   }
   
}
