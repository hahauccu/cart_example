<?php

namespace App\Http\Controllers;

use App\Models\ProductList;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
   public function showList()
   {
   	$productList = ProductList::get()->toArray();
   	return view("product_list",
        [
            "productList" =>$productList
        ]);
   }
}
