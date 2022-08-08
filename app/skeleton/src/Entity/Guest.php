<?php

namespace App\Entity;

use App\Repository\GuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GuestRepository::class)]
class Guest
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
     * @Assert\Regex("^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$^")
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'fromGuest', targetEntity: Payment::class)]
    private Collection $incomingPayments;

    #[ORM\OneToMany(mappedBy: 'toGuest', targetEntity: Payment::class)]
    private Collection $outcommingPayments;

    #[ORM\OneToMany(mappedBy: 'customerGuest', targetEntity: Cheque::class)]
    private Collection $cheques;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'guests')]
    private Collection $products;

    public function __construct()
    {
        $this->incomingPayments = new ArrayCollection();
        $this->outcommingPayments = new ArrayCollection();
        $this->cheques = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getIncomingPayments(): Collection
    {
        return $this->incomingPayments;
    }

    public function addIncomingPayment(Payment $incomingPayment): self
    {
        if (!$this->incomingPayments->contains($incomingPayment)) {
            $this->incomingPayments->add($incomingPayment);
            $incomingPayment->setFromGuest($this);
        }

        return $this;
    }

    public function removeIncomingPayment(Payment $incomingPayment): self
    {
        if ($this->incomingPayments->removeElement($incomingPayment)) {
            // set the owning side to null (unless already changed)
            if ($incomingPayment->getFromGuest() === $this) {
                $incomingPayment->setFromGuest(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getOutcommingPayments(): Collection
    {
        return $this->outcommingPayments;
    }

    public function addOutcommingPayment(Payment $outcommingPayment): self
    {
        if (!$this->outcommingPayments->contains($outcommingPayment)) {
            $this->outcommingPayments->add($outcommingPayment);
            $outcommingPayment->setToGuest($this);
        }

        return $this;
    }

    public function removeOutcommingPayment(Payment $outcommingPayment): self
    {
        if ($this->outcommingPayments->removeElement($outcommingPayment)) {
            // set the owning side to null (unless already changed)
            if ($outcommingPayment->getToGuest() === $this) {
                $outcommingPayment->setToGuest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cheque>
     */
    public function getCheques(): Collection
    {
        return $this->cheques;
    }

    public function addCheque(Cheque $cheque): self
    {
        if (!$this->cheques->contains($cheque)) {
            $this->cheques->add($cheque);
            $cheque->setCustomerGuest($this);
        }

        return $this;
    }

    public function removeCheque(Cheque $cheque): self
    {
        if ($this->cheques->removeElement($cheque)) {
            // set the owning side to null (unless already changed)
            if ($cheque->getCustomerGuest() === $this) {
                $cheque->setCustomerGuest(null);
            }
        }

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
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

}
