<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiUserController extends AbstractController
{
    /**
     * Route("/api/users", name="api_users", methods={"GET"})
     *
     *
     * @OA\Response(
     *      response=200,
     *      description="returns JSON result, the list of users a customer",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Customer::class, groups={"Default", "users:list", "user:read"}))
     *      ),
     * )
     * @OA\Tag(name="User")
     *
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function list(UserRepository $repository)
    {
        return $this->json($repository->findBy(["customer" => $this->getUser()]), Response::HTTP_OK, [], ['groups' => ['users:list', 'user:read']]);
    }

    /**
     * @Route("/api/users/{id}", name="api_user_show", methods={"GET"})
     *
     * @OA\Tag(name="User")
     *
     * @param User $user
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function show(User $user, UserRepository $repository)
    {
        if ($user->getCustomer() == $this->getUser()) {
            return $this->json($repository->findBy(['id' => $user->getId()]), Response::HTTP_OK, [], ['groups' => ['user:read', 'users:list']]);
        }
        return $this->json("Vous n'avez pas les autorisations pour voir le détail de cet utilisateur !", Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/api/users", name="api_user_create", methods={"POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SerializerInterface $serializer
     * @param UrlGeneratorInterface $urlGenerator
     * @return JsonResponse
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer, UrlGeneratorInterface $urlGenerator, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        /** @var User $user */
        $user = $serializer->deserialize($data, User::class, 'json');
        $errors = $validator->validate($user);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $user->setCustomer($this->getUser());
        $manager->persist($user);
        $manager->flush();
        return new JsonResponse(
            $serializer->serialize($user, "json", ["groups" => ['users:list', 'user:read']]),
            JsonResponse::HTTP_CREATED,
            ["Location" => $urlGenerator->generate("api_user_show", ["id" => $user->getid()])],
            true
        );
    }

    /**
     * @Route("/api/users/{id}", name="api_user_delete", methods={"DELETE"})
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */
    public function delete(User $user, EntityManagerInterface $manager)
    {
        if ($user->getCustomer() == $this->getUser()) {
            $manager->remove($user);
            $manager->flush();
            return $this->json("La donnée a bien été supprimée", Response::HTTP_OK);
        }
        return $this->json("Vous n'avez pas les autorisations pour supprimer cet utilisateur !", Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
