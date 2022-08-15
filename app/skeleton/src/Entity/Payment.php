<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @Assert\Positive
     */
    #[ORM\Column]
    private ?float $value = null;


    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'incomingPayments')]
    private ?Guest $fromGuest = null;

    #[ORM\ManyToOne(cascade: ['persist'],inversedBy: 'outcommingPayments')]
    private ?Guest $toGuest = null;



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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }


    public function getFromGuest(): ?Guest
    {
        return $this->fromGuest;
    }

    public function setFromGuest(?Guest $fromGuest): self
    {
        $this->fromGuest = $fromGuest;

        return $this;
    }

    public function getToGuest(): ?Guest
    {
        return $this->toGuest;
    }

    public function setToGuest(?Guest $toGuest): self
    {
        $this->toGuest = $toGuest;

        return $this;
    }

}
