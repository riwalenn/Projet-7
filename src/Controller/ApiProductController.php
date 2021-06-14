<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ApiProductController extends AbstractController
{
    /**
     * Return list of products
     *
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get products list",
     *     @OA\Response(
     *          response=200,
     *     description="OK",
     *     @OA\JsonContent(ref=@Model(type=Product::class)),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=500, description="Internal error"),
     * ),
     * @OA\Tag(name="Product")
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
     * Return Product detail
     *
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get Product detail",
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="string"), @OA\Examples(example="int", value="1",summary="An int value")),
     *     @OA\Response(
     *          response=200,
     *     description="OK",
     *     @OA\JsonContent(ref=@Model(type=Product::class)),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=500, description="Internal error"),
     * ),
     *
     * @OA\Tag(name="Product")
     * @param Product $product
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function show(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $jsonContent = $serializer->serialize($product, 'json', SerializationContext::create()->setGroups(["Default", "product:detail"]));
        if (empty($jsonContent)) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }
}
