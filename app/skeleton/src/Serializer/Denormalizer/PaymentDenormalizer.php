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

        $this->setSimpleFields($payment, $data);
        $this->setObjectFields($payment, $data, $this->em);

        return $payment;
    }

    public static function setSimpleFields($object, $data)
    {
        if (key_exists('value', $data)) $object->setValue($data['value']);
        if (key_exists('date', $data)) $object->setDate($data['date']);
        else $object->setDate(new \DateTimeImmutable());
    }
    public static function setObjectFields($object, $data, EntityManagerInterface $em)
    {
        $payment = $object;
        if (key_exists('fromGuest', $data)) {
            if (key_exists('id', $data['fromGuest'])) {
                $fromGuest = $em->find(Guest::class, $data['fromGuest']['id']);
                if ($fromGuest == null ) {
                    $fromGuest = new Guest();
                    GuestDenormalizer::setSimpleFields($fromGuest, $data['fromGuest']);
                }
            } else {
                $fromGuest = new Guest();
                GuestDenormalizer::setSimpleFields($fromGuest, $data['fromGuest']);
            }
            $payment->setFromGuest($fromGuest);
        }

        if (key_exists('toGuest', $data)) {
            if (key_exists('id', $data['toGuest'])) {
                $toGuest = $em->find(Guest::class, $data['toGuest']['id']);
                if ($toGuest == null) {
                    $toGuest = new Guest();
                    GuestDenormalizer::setSimpleFields($toGuest, $data['toGuest']);
                }
            } else {
                $toGuest = new Guest();
                GuestDenormalizer::setSimpleFields($toGuest, $data['toGuest']);
            }
            $payment->setToGuest($toGuest);
        }
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Payment::class == $type;
    }

}