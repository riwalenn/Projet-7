<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param Customer $customer
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function show(Customer $customer, UserRepository $repository)
    {
        return $this->json($repository->findBy(array('id' => $customer->getId())), Response::HTTP_OK, [], ['groups' => 'user:read']);
    }
}
