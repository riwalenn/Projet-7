<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class ApiProductController extends AbstractController
{
    /**
     * Route("/api/products", name="api_products", methods={"GET"})
     *
     * @param ProductRepository $repo
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
   public function list(ProductRepository $repo, SerializerInterface $serializer): JsonResponse
   {
       $jsonContent = $serializer->serialize($repo->findAll(), 'json', SerializationContext::create()->setGroups(["Default", "product:read"]));
       return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
   }

    /**
     * Route("/api/products/{id}", name="api_products_show", methods={"GET"})
     *
     * @param Product $product
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function show(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $jsonContent = $serializer->serialize($product, 'json', SerializationContext::create()->setGroups(["Default", "product:detail"]));
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }
}
