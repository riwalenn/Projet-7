<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiProductController extends AbstractController
{
    /**
     * Route("/api/products", name="api_products", methods={"GET"})
     */
   public function list(ProductRepository $repo, SerializerInterface $serializer)
   {
        $products = $repo->findAll();

        $result = $serializer->serialize($products, 'json');
        return new JsonResponse($result, 200, [], true);
   }

    /**
     * Route("/api/products/{id}", name="api_products_show", methods={"GET"})
     */
    public function show(Product $product, SerializerInterface $serializer)
    {
        $result = $serializer->serialize($product, 'json');
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }
}
