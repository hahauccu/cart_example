<?php
namespace App\Service;
use App\Repositories\ProductRepository;


class ProductService
{
	public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function get()
    {
    	return $this->productRepository->get();
    }
}