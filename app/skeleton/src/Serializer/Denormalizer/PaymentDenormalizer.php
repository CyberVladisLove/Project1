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

class PaymentDenormalizer extends AbstractDenormalizer
{


    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array $context
     * @return Payment
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $payment = $this->getObject(Payment::class, $context);

        if (key_exists('value', $data)) $payment->setValue($data['value']);
        if (!key_exists('date', $data)) $payment->setDate(new \DateTimeImmutable());

        if (key_exists('fromGuest', $data)) {
            if (key_exists('id', $data['fromGuest'])) {
                $fromGuest = $this->em->find(Guest::class, $data['fromGuest']['id']);
                if ($fromGuest == null ) {
                    $fromGuest = new Guest();
                    $fromGuest->setName($data['fromGuest']['name']);
                    $fromGuest->setPhone($data['fromGuest']['phone']);
                }

            } else {
                $fromGuest = new Guest();
                $fromGuest->setName($data['fromGuest']['name']);
                $fromGuest->setPhone($data['fromGuest']['phone']);
            }
            $payment->setFromGuest($fromGuest);
        }

        if (key_exists('toGuest', $data)) {
            if (key_exists('id', $data['toGuest'])) {
                $toGuest = $this->em->find(Guest::class, $data['toGuest']['id']);
                if ($toGuest == null) {
                    $toGuest = new Guest();
                    $toGuest->setName($data['toGuest']['name']);
                    $toGuest->setPhone($data['toGuest']['phone']);
                }

            } else {

                $toGuest = new Guest();
                $toGuest->setName($data['toGuest']['name']);
                $toGuest->setPhone($data['toGuest']['phone']);
            }
            $payment->setToGuest($toGuest);
        }



        return $payment;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Payment::class == $type;
    }

}