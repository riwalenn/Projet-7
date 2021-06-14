<?php

namespace App\Controller;

use App\Entity\Customer;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApiSecurityController extends AbstractController
{
    /**
     * @OA\Post(
     *     path="/api/login_check",
     *     summary="Authentication",
     *     @OA\Parameter(in="path", name="username", required=true, @OA\Schema(type="string"), @OA\Examples(example="string", value="",summary="An string value")),
     *     @OA\Parameter(in="path", name="password", required=true, @OA\Schema(type="string"), @OA\Examples(example="string", value="",summary="An string value")),
     *     @OA\Response(
     *          response=200,
     *     description="OK",
     *     @OA\JsonContent(ref=@Model(type=Customer::class)),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=500, description="Internal error"),
     * )
     * @OA\Tag(name="Login")
     */
   public function login(TokenStorageInterface $tokenStorage) {
       $token = $tokenStorage->getToken();
       return $this->json($token);
   }
}
