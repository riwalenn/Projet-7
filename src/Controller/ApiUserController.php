<?php

namespace App\Controller;

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

class ApiUserController extends AbstractController
{
    /**
     * @Route("/api/users/{id}", name="api_user_show", methods={"GET"})
     *
     * @param User $user
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function show(User $user, UserRepository $repository)
    {
        return $this->json($repository->findBy(array('id' => $user->getId())), Response::HTTP_OK, [], ['groups' => ['user:read', 'users:list']]);
    }

    /**
     * @Route("/api/users", name="api_user_create", methods={"POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer, User $user): JsonResponse
    {
        $data = $request->getContent();
        $user = $serializer->deserialize($data, User::class, 'json');
        //$user->setCustomer($this->getUser());
        $manager->persist($user);
        $manager->flush();

        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $this->generateUrl('api_user_show', ["id" => $user->getId(), UrlGeneratorInterface::ABSOLUTE_URL])], true);
    }

    /**
     * @Route("/api/users/{id}", name="api_user_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserRepository $repository
     * @param User $user
     * @return JsonResponse
     */
    public function delete(Request $request, EntityManagerInterface $manager, UserRepository $repository, User $user)
    {
        $manager->remove($request);
        return new JsonResponse(null, Response::HTTP_ACCEPTED, []);
    }
}
