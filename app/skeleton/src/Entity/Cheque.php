<?php

namespace App\Entity;

use App\Interface\IHaveAuthor;
use App\Repository\ChequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ChequeRepository::class)]
class Cheque implements IHaveAuthor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]

    private ?string $shop = null;

    #[ORM\ManyToOne(cascade: ['persist'],inversedBy: 'cheques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $customerGuest = null;

    #[ORM\OneToMany(mappedBy: 'cheque', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\ManyToOne(inversedBy: 'authorForCheques')]
    private ?User $author = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getShop(): ?string
    {
        return $this->shop;
    }

    public function setShop(?string $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getCustomerGuest(): ?Guest
    {
        return $this->customerGuest;
    }

    public function setCustomerGuest(?Guest $customerGuest): self
    {
        $this->customerGuest = $customerGuest;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCheque($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCheque() === $this) {
                $product->setCheque(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getId() .")". $this->getShop() ." ". $this->getCustomerGuest();
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
