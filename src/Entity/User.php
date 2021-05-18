<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use JMS\Serializer\Annotation\Groups as Groups;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\XmlRoot("User")
 * @Hateoas\Relation("self", href = "expr('/api/users/' ~ object.getId())")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @Serializer\XmlAttribute
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @OA\Property(description="Unique identifier of the user", type="integer")
     * @Exclude
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default","user:read", "user:write"})
     *
     * @OA\Property(description="Name of the user", type="string")
     * @Assert\Length(min=4, minMessage="Le nom doit au moins contenir {{ limit }} caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default","user:read", "user:write"})
     *
     * @OA\Property(description="Firstname of the user", type="string")
     * @Assert\Length(min=4, minMessage="Le prénom doit au moins contenir {{ limit }} caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default","user:read", "user:write"})
     *
     * @OA\Property(description="Email of the user", type="email")
     * @Assert\NotBlank(message="l'email ne peut être vide.")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     *
     * @OA\Property(description="Customer of the user")
     * @Exclude
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getfirstName(): ?string
    {
        return $this->firstName;
    }

    public function setfirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
