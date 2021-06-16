<?php

namespace App\Http\Controllers;

use App\Service\ProductService;


class ProductController 
{

	public function __construct(ProductService $productService)
	{
        $this->productService = $productService;
    }

   public function showList()
   {
   	return view("product_list",
        [
            "productList" =>$this->productService->get()
        ]);
   }
}
