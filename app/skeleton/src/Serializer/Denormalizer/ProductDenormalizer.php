<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Cheque;
use App\Entity\Guest;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ProductDenormalizer extends AbstractDenormalizer
{

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $product = $this->getObject(Product::class, $context);

        $this->setSimpleFields($product, $data);
        $this->setObjectFields($product, $data, $this->em);
        
        return $product;
    }
    public static function setSimpleFields($object, $data)
    {
        if (key_exists('name', $data)) $object->setName($data['name']);
        if (key_exists('price', $data)) $object->setPrice($data['price']);
        if (key_exists('count', $data)) $object->setCount($data['count']);
    }
    public static function setObjectFields($object, $data, EntityManagerInterface $em)
    {
        $product = $object;
        if (key_exists('cheque', $data)) {
            if (key_exists('id', $data['cheque'])) {
                $cheque = $em->find(Cheque::class, $data['cheque']['id']);
                if ($cheque == null ) {
                    $customerGuest = $em->find(Guest::class, $data['cheque']['customerGuest']['id']);
                    $cheque = new Cheque();
                    $cheque->setCustomerGuest($customerGuest);
                    ChequeDenormalizer::setSimpleFields($cheque, $data['cheque']);
                }

            } else {
                $customerGuest = $em->find(Guest::class, $data['cheque']['customerGuest']['id']);
                $cheque = new Cheque();
                $cheque->setCustomerGuest($customerGuest);
                ChequeDenormalizer::setSimpleFields($cheque, $data['cheque']);
            }
            $product->setCheque($cheque);
        }

        if (key_exists('guests', $data)) {

            foreach ($data['guests'] as $guestFromReq) {
                if (key_exists('id', $guestFromReq)) {
                    $guest = $em->find(Guest::class, $guestFromReq['id']);
                    if ($guest == null) {
                        $guest = new Guest();
                        GuestDenormalizer::setSimpleFields($guest, $guestFromReq);
                    }
                } else {
                    $guest = new Guest();
                    GuestDenormalizer::setSimpleFields($guest, $guestFromReq);
                }

                $product->addGuest($guest);
            }
        }
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Product::class == $type;
    }
}