<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use OpenApi\Annotations as OA;

/**
 * @Serializer\XmlRoot("Product")
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *     "api_products",
 *     absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation(
 *     "show",
 *     href = @Hateoas\Route(
 *     "api_products_show",
 *     parameters = { "id" = "expr(object.getId())" },
 *     absolute = true
 *     )
 * )
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @OA\Property(description="Unique identifier of the product", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     *
     * @OA\Property(description="denomination of the product", type="string")
     */
    private $denomination;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     *
     * @OA\Property(description="Manufacturer of the product", type="string")
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     *
     * @OA\Property(description="Processor of the product", type="string")
     */
    private $processorName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     *
     * @OA\Property(description="Color of the product", type="string")
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read"})
     *
     * @OA\Property(description="Ram Memory of the product", type="string")
     */
    private $ramMemory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getProcessorName(): ?string
    {
        return $this->processorName;
    }

    public function setProcessorName(string $processorName): self
    {
        $this->processorName = $processorName;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getRamMemory(): ?string
    {
        return $this->ramMemory;
    }

    public function setRamMemory(string $ramMemory): self
    {
        $this->ramMemory = $ramMemory;

        return $this;
    }
}
