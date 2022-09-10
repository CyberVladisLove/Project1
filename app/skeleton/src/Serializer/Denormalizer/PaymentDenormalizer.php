<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Guest;
use App\Entity\Payment;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentDenormalizer extends AbstractDenormalizer
{
    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return Payment
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Payment
    {
        $payment = new Payment();
        $payment->setValue($data['value']);

        if (key_exists('fromGuest', $data)) {
            if (key_exists('id', $data['fromGuest'])) {
                $fromGuest = $this->em->find(Guest::class, $data['fromGuest']['id']);
                if ($fromGuest == null ) {
                    $fromGuest = $this->createGuest($data['toGuest']);
                    //$fromGuest = $this->jsonToEntity($data['fromGuest'],Guest::class);
                }
            } else {
                $fromGuest = $this->createGuest($data['toGuest']);
                //$fromGuest = $this->jsonToEntity($data['fromGuest'],Guest::class);
            }
            $payment->setFromGuest($fromGuest);
        }

        if (key_exists('toGuest', $data)) {
            if (key_exists('id', $data['toGuest'])) {
                $toGuest = $this->em->find(Guest::class, $data['toGuest']['id']);
                if ($toGuest == null) {
                    $toGuest = $this->createGuest($data['toGuest']);
                   // $toGuest = $this->jsonToEntity($data['fromGuest'],Guest::class);
                }
            } else {
                $toGuest = $this->createGuest($data['toGuest']);
                //$toGuest = $this->jsonToEntity($data['fromGuest'],Guest::class);
            }
            $payment->setToGuest($toGuest);
        }


        $payment->setDate(new \DateTimeImmutable());
        return $payment;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Payment::class == $type;
    }

    public function createGuest(mixed $jsonGuest): Guest
    {
        $guest = new Guest();
        if (key_exists('user', $jsonGuest)) $guest->setByUser($jsonGuest['user']);
        if (key_exists('phone', $jsonGuest)) $guest->setPhone($jsonGuest['phone']);
        return $guest;
    }


}