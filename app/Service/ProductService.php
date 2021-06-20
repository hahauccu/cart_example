<?php
namespace App\Service;
//Repositories
use App\Repositories\ProductRepository;



class ProductService
{
	protected $productRepository;
	public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function get()
    {
    	return $this->productRepository->get();
    }
}