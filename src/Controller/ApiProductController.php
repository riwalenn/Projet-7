<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiProductController
 * @package App\Controller
 * @Route("/api/products
 * ")
 */
class ApiProductController extends AbstractController
{
    /**
     * Route("/api/products", name="api_products", methods={"GET"})
     *
     *
     * @OA\Response(
     *      response=200,
     *      description="Return the JSON result of BileMo Products list",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Product::class, groups={"Default"}))
     *      ),
     * )
     * @OA\Tag(name="Product")
     *
     * @param ProductRepository $repo
     * @return JsonResponse
     */
   public function list(ProductRepository $repo)
   {
       return $this->json($repo->findAll(), Response::HTTP_OK, [], ['groups' => ['Default', 'product:read']]);
   }

    /**
     * Route("/api/products/{id}", name="api_products_show", methods={"GET"})
     *
     *  @OA\Response(
     *      response=200,
     *      description="Return the JSON of one result of BileMo Product",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Product::class, groups={"Default"}))
     *      ),
     * )
     * @OA\Tag(name="Product")
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return $this->json($product, Response::HTTP_OK, [], ['groups' => ['Default', 'product:read']]);
    }
}
