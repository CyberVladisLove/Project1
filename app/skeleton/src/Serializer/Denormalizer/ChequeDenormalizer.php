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

        if (!key_exists('date', $data)) $cheque->setDate(new DateTime());
        if (key_exists('shop', $data)) $cheque->setShop($data['shop']);

        if (key_exists('customerGuest', $data)) {
            if (key_exists('id', $data['customerGuest'])) {
                $customerGuest = $this->em->find(Guest::class, $data['customerGuest']['id']);
                if ($customerGuest == null ) {
                    $customerGuest = new Guest();
                    $customerGuest->setName($data['customerGuest']['name']);
                    $customerGuest->setPhone($data['customerGuest']['phone']);
                }
            } else {
                $customerGuest = new Guest();
                $customerGuest->setName($data['customerGuest']['name']);
                $customerGuest->setPhone($data['customerGuest']['phone']);
            }

            $cheque->setCustomerGuest($customerGuest);
        }


        return $cheque;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Cheque::class == $type;
    }
}