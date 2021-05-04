<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiProductController extends AbstractController
{
    /**
     * Route("/api/products", name="api_products", methods={"GET"})
     * @param ProductRepository $repo
     * @return JsonResponse
     */
   public function list(ProductRepository $repo)
   {
       return $this->json($repo->findAll(), Response::HTTP_OK, [], ['groups' => 'product:read']);
   }

    /**
     * Route("/api/products/{id}", name="api_products_show", methods={"GET"})
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return $this->json($product, Response::HTTP_OK, [], ['groups' => 'product:read']);
    }
}
