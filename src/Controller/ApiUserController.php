<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ApiUserController extends AbstractController
{
    /**
     * Route("/api/users", name="api_users", methods={"GET"})
     *
     * @param UserRepository $repository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function list(UserRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $jsonContent = $serializer->serialize($repository->findBy(["customer" => $this->getUser()]), 'json', SerializationContext::create()->setGroups(['Default', 'users:list']));
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/users/{id}", name="api_user_show", methods={"GET"})
     *
     * @param User $user
     * @param UserRepository $repository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function show(User $user, UserRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        if ($user->getCustomer() == $this->getUser()) {
            $jsonContent = $serializer->serialize($repository->findBy(['id' => $user->getId()]), 'json', SerializationContext::create()->setGroups(['Default', 'users:list']));
            return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
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
     * @param ValidatorInterface $validator
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
            $serializer->serialize($user, "json", SerializationContext::create()->setGroups(['Default', 'users:list', 'user:read'])),
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
