<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Cheque;
use App\Entity\Guest;
use App\Entity\Payment;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ChequeDenormalizer extends AbstractDenormalizer
{

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $cheque = $this->getObject(Cheque::class, $context);

        $this->setSimpleFields($cheque, $data);
        $this->setObjectFields($cheque, $data, $this->em);

        return $cheque;
    }

    public static function setSimpleFields($object, $data)
    {
        if (key_exists('date', $data)) $object->setDate($data['date']);
        else $object->setDate(new DateTime());

        if (key_exists('shop', $data)) $object->setShop($data['shop']);
    }

    public static function setObjectFields($object, $data, EntityManagerInterface $em)
    {
        $cheque = $object;
        if (key_exists('customerGuest', $data)) {
            if (key_exists('id', $data['customerGuest'])) {
                $customerGuest = $em->find(Guest::class, $data['customerGuest']['id']);
                if ($customerGuest == null ) {
                    $customerGuest = new Guest();
                    GuestDenormalizer::setSimpleFields($customerGuest, $data['customerGuest']);
                }
            } else {
                $customerGuest = new Guest();
                GuestDenormalizer::setSimpleFields($customerGuest, $data['customerGuest']);
            }

            $cheque->setCustomerGuest($customerGuest);
        }
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Cheque::class == $type;
    }
}