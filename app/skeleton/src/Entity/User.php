<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Guest::class)]
    #[Ignore]
    private Collection $AuthorForGuests;

    #[ORM\OneToMany(mappedBy: 'byUser', targetEntity: Guest::class)]
    #[Ignore]
    private Collection $IsForGuests;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Cheque::class)]
    #[Ignore]
    private Collection $authorForCheques;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Product::class)]
    #[Ignore]
    private Collection $authorForProducts;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Payment::class)]
    #[Ignore]
    private Collection $authorForPayments;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Party::class)]
    #[Ignore]
    private Collection $authorForParties;

    public function __construct()
    {
        $this->AuthorForGuests = new ArrayCollection();
        $this->IsForGuests = new ArrayCollection();
        $this->authorForCheques = new ArrayCollection();
        $this->authorForProducts = new ArrayCollection();
        $this->authorForPayments = new ArrayCollection();
        $this->authorForParties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getAuthorForGuests(): Collection
    {
        return $this->AuthorForGuests;
    }

    public function addGuest(Guest $guest): self
    {
        if (!$this->AuthorForGuests->contains($guest)) {
            $this->AuthorForGuests->add($guest);
            $guest->setAuthor($this);
        }

        return $this;
    }

    public function removeGuest(Guest $guest): self
    {
        if ($this->AuthorForGuests->removeElement($guest)) {
            // set the owning side to null (unless already changed)
            if ($guest->getAuthor() === $this) {
                $guest->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getIsForGuests(): Collection
    {
        return $this->IsForGuests;
    }

    public function addForGuest(Guest $forGuest): self
    {
        if (!$this->IsForGuests->contains($forGuest)) {
            $this->IsForGuests->add($forGuest);
            $forGuest->setByUser($this);
        }

        return $this;
    }

    public function removeForGuest(Guest $forGuest): self
    {
        if ($this->IsForGuests->removeElement($forGuest)) {
            // set the owning side to null (unless already changed)
            if ($forGuest->getByUser() === $this) {
                $forGuest->setByUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cheque>
     */
    public function getAuthorForCheques(): Collection
    {
        return $this->authorForCheques;
    }

    public function addAuthorForCheque(Cheque $authorForCheque): self
    {
        if (!$this->authorForCheques->contains($authorForCheque)) {
            $this->authorForCheques->add($authorForCheque);
            $authorForCheque->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorForCheque(Cheque $authorForCheque): self
    {
        if ($this->authorForCheques->removeElement($authorForCheque)) {
            // set the owning side to null (unless already changed)
            if ($authorForCheque->getAuthor() === $this) {
                $authorForCheque->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getAuthorForProducts(): Collection
    {
        return $this->authorForProducts;
    }

    public function addAuthorForProduct(Product $authorForProduct): self
    {
        if (!$this->authorForProducts->contains($authorForProduct)) {
            $this->authorForProducts->add($authorForProduct);
            $authorForProduct->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorForProduct(Product $authorForProduct): self
    {
        if ($this->authorForProducts->removeElement($authorForProduct)) {
            // set the owning side to null (unless already changed)
            if ($authorForProduct->getAuthor() === $this) {
                $authorForProduct->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getAuthorForPayments(): Collection
    {
        return $this->authorForPayments;
    }

    public function addAuthorForPayment(Payment $authorForPayment): self
    {
        if (!$this->authorForPayments->contains($authorForPayment)) {
            $this->authorForPayments->add($authorForPayment);
            $authorForPayment->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorForPayment(Payment $authorForPayment): self
    {
        if ($this->authorForPayments->removeElement($authorForPayment)) {
            // set the owning side to null (unless already changed)
            if ($authorForPayment->getAuthor() === $this) {
                $authorForPayment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getAuthorForParties(): Collection
    {
        return $this->authorForParties;
    }

    public function addAuthorForParty(Party $authorForParty): self
    {
        if (!$this->authorForParties->contains($authorForParty)) {
            $this->authorForParties->add($authorForParty);
            $authorForParty->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorForParty(Party $authorForParty): self
    {
        if ($this->authorForParties->removeElement($authorForParty)) {

            if ($authorForParty->getAuthor() === $this) {
                $authorForParty->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
