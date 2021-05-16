<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @OA\Property(description="Unique identifier of the customer", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:list"})
     *
     * @OA\Property(description="Username of the customer", type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:list"})
     *
     * @OA\Property(description="Email of the customer", type="email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @OA\Property(description="Password of the customer", type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="simple_array")
     *
     * @OA\Property(description="Role of the customer", type="simple_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="customer")
     * @Groups({"users:list"})
     *
     * @OA\Property(description="Users of the customer")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return Collection|User[]
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCustomer($this);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return Collection|User[]
     */
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCustomer() === $this) {
                $user->setCustomer(null);
            }
        }

        return $this;
    }
}
