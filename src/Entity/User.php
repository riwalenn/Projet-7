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
 * @Hateoas\Relation("delete", href = "expr('/api/users/' ~ object.getId())")
 * @Hateoas\Relation("list")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @OA\Schema(title="User", description="User class")
 */
class User
{
    /**
     * @Serializer\XmlAttribute
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @OA\Property(type="integer")
     * @Exclude
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default","user:read", "user:write"})
     *
     * @OA\Property(description="Name of the user", type="string")
     * @Assert\Length(min=4, minMessage="Name must have {{ limit }} caracters")
     * @Assert\NotBlank(message="Name is missing")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default","user:read", "user:write"})
     *
     * @OA\Property(description="firstName of the user", type="string")
     * @Assert\Length(min=4, minMessage="firstName must have {{ limit }} caracters")
     * @Assert\NotBlank(message="firstName is missing")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Default","user:read", "user:write"})
     *
     * @OA\Property(type="string")
     * @Assert\NotBlank(message="Email is missing")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
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
