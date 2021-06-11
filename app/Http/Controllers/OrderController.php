<?php

namespace App\Http\Controllers;

//models
use App\Models\ProductList;
use App\Models\Discount;
use App\Models\PurchasedProductList;
use App\Models\CheckOut;


class OrderController 
{
   public function list()
   {
   	$orderData = CheckOut::where("user_id",1)->get();
   	if(empty($orderData))
   	{
   		$orderData = $orderData->toArray();
   	}

   	$orderData = $orderData->toArray();
   	return view("order_list",
        [
            "orderData" =>$orderData
        ]);
   }
   public function listDetail($random_id="")
   {
   	$ProductList = ProductList::get()->toArray();
   	$ProductListArray = array();
   	foreach ($ProductList as $key => $value) 
   	{
   		$ProductListArray[$value["id"]] = $value;
   	}


   	$orderData = CheckOut::where("random_id",$random_id)->with("productContent","discountContent")->first();
   	if(!empty($orderData))
   	{
   		$orderData = $orderData->toArray();
   	}
   	
   	foreach ($orderData["product_content"] as $key => $value) 
   	{
   		$ProductListArray[$value['product_id']]["purchased_number"]=$value["purchased_number"];
   		$orderData["product_content"][$key]=$ProductListArray[$value['product_id']];
   	}

   	return view("order_list_detail",
        [
            "orderData" =>$orderData
        ]);
    
   }
   
}
