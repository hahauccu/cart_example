<?php
namespace App\Repositories;
use App\Models\ProductList;


class ProductRepository 
{
    protected $productList;


    public function __construct(ProductList $productList)
    {
        $this->productList = $productList;
       
    }

    public function get()
    {
      return $this->productList::get()->toArray();
    }

    public function getProductById($productId)
    {
      return $this->productList::where("id",$productId)->first()->toArray();
    }

    public function getProductByIdArray($productId)
    {
      return $this->productList::whereIn("id",$productId)->get()->toArray();
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
      return $this->productList::whereIn("id",$productId)->get()->toArray();
    }
}