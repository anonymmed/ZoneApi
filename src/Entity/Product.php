<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={"pagination_enabled=true"}, itemOperations={"get", "delete", "put", "patch"},
 * collectionOperations={"get" = {"method" = "GET" , "path" = "/list" , "maximumItemsPerPage"=1}, "rating" = {"method" = "post" , "path" = "/rate"}, "post"})
 * @ApiFilter(OrderFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    use TimeStamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float", options={"default" : 0})
     * @Assert\Length(min=0, max=5)
     */
    private $rating;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Variation", inversedBy="product")
     * @ORM\JoinColumn(name="variation_id", referencedColumnName="id")
     */
    private $variation;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getVariation(): ?Variation
    {
        return $this->variation;
    }

    public function setVariation(?Variation $variation): self
    {
        $this->variation = $variation;

        return $this;
    }
}
