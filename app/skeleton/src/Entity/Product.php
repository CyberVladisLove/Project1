<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Interface\IHaveAuthor;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements IHaveAuthor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @Assert\PositiveOrZero
     */
    #[ORM\Column]
    private ?int $price = null;

    /**
     * @Assert\Positive
     */
    #[ORM\Column]
    private ?float $count = null;

    #[ORM\ManyToMany(targetEntity: Guest::class, mappedBy: 'products')]
    private Collection $guests;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Cheque $cheque = null;

    #[ORM\ManyToOne(inversedBy: 'authorForProducts')]
    private ?User $author = null;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCount(): ?float
    {
        return $this->count;
    }

    public function setCount(float $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(Guest $guest): self
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->addProduct($this);
        }

        return $this;
    }

    public function removeGuest(Guest $guest): self
    {
        if ($this->guests->removeElement($guest)) {
            $guest->removeProduct($this);
        }

        return $this;
    }

    public function getCheque(): ?Cheque
    {
        return $this->cheque;
    }

    public function setCheque(?Cheque $cheque): self
    {
        $this->cheque = $cheque;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
