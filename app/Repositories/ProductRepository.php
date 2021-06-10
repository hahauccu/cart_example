<?php
namespace App\Repositories;

Use BaseFunction;
Use Config;
use App\Models\ProductList;


class ProductRepository 
{
    protected $productList;


    public function __construct(ProductList $productList)
    {
        $this->productList = $productList;
       
    }

    public function checkStock($productId)
    {
      $productList = new $this->productList;
      if(is_array($productId))
      {
        $toReturnArray = array();
        $productsData = $productList::whereIn("id",$productId)->get()->toArray();
        foreach ($productsData as $key => $value) 
        {
          $toReturnArray[$value["id"]] = $value["stock"];
        }

        return $toReturnArray;

      }
      else
      {
        $productsData = $productList::where("id",$productId)->first()->toArray();
        return $productsData["stock"];
      }

    }

    public function getProductData($productId)
    {
      $productList = new $this->productList;
      $productsData = $productList::whereIn("id",$productId)->get()->toArray();
      return $productsData;
    }
}