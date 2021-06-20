<?php
namespace App\Repositories;
//Models
use App\Models\PurchasedProductList;
use App\Models\ProductList;


class ProductRepository 
{
    protected $productList;
    protected $purchasedProductList;


    public function __construct(ProductList $productList,PurchasedProductList $purchasedProductList)
    {
        $this->productList = $productList;
        $this->purchasedProductList = $purchasedProductList;
       
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

    public function savePurchasedProductList($toSaveData)
    {
      $toSaveProductList = new $this->purchasedProductList();
      foreach ($toSaveData as $key => $value) 
      {
        $toSaveProductList->$key=$value;
      }
      $toSaveProductList->save();
    }

    public function updateProductStock($id,$numbers)
    {
      $productList = $this->productList;
      $toUpdateProduct = $productList::where("id",$id)->first();
    $toUpdateProduct->stock+=$numbers;
    $toUpdateProduct->save();
    }
}