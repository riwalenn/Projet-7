<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiCustomerController extends AbstractController
{
    /**
     * Route("/api/customers/{id}/", name="api_users", methods={"GET"})
     * @param Customer $customer
     * @param CustomerRepository $repository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function list(Customer $customer, CustomerRepository $repository, SerializerInterface $serializer)
    {
        $result =  $serializer->serialize($repository->findBy(array('id' => $customer->getId())), 'json', ['groups' => ['users:list', 'user:read']]);
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/customers/users/{id}", name="api_user_show", methods={"GET"})
     * @param User $user
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function show(User $user, UserRepository $repository)
    {
        return $this->json($repository->findBy(array('id' => $user->getId())), Response::HTTP_OK, [], ['groups' => 'user:read']);
    }

    /**
     * @Route("/api/customers/{id}/create", name="api_user_create", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SerializerInterface $serializer
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $jsonContent = $request->getContent();
        $user = $serializer->deserialize($jsonContent, User::class, 'json');

        $manager->persist($user);
        $manager->flush();
    }
}
