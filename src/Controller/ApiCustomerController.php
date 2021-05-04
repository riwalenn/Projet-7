<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->json($repository->findBy(array('id' => $customer->getId())), Response::HTTP_OK, [], ['groups' => ['users:list', 'user:read']]);
    }
}
