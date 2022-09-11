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

        if (key_exists('name', $data)) $product->setName($data['name']);
        if (key_exists('price', $data)) $product->setPrice($data['price']);
        if (key_exists('count', $data)) $product->setCount($data['count']);

        if (key_exists('cheque', $data)) {
            if (key_exists('id', $data['cheque'])) {
                $cheque = $this->em->find(Cheque::class, $data['cheque']['id']);
                if ($cheque == null ) {
                    $customerGuest = $this->em->find(Guest::class, $data['cheque']['customerGuest']['id']);
                    $cheque = new Cheque();
                    $cheque->setCustomerGuest($customerGuest);
                    $cheque->setDate(new \DateTimeImmutable());
                    $cheque->setShop($data['cheque']['shop']);
                }

            } else {
                $customerGuest = $this->em->find(Guest::class, $data['cheque']['customerGuest']['id']);
                $cheque = new Cheque();
                $cheque->setCustomerGuest($customerGuest);
                $cheque->setDate(new \DateTimeImmutable());
                $cheque->setShop($data['cheque']['shop']);
            }
            $product->setCheque($cheque);
        }
        if (key_exists('guests', $data)) {

            foreach ($data['guests'] as $guestFromReq) {
                if (key_exists('id', $guestFromReq)) {
                    $guest = $this->em->find(Guest::class, $guestFromReq['id']);
                    if ($guest == null) {
                        $guest = new Guest();
                        $guest->setName($guestFromReq['name']);
                        $guest->setPhone($guestFromReq['phone']);
                    }
                } else {
                    $guest = new Guest();
                    $guest->setName($guestFromReq['name']);
                    $guest->setPhone($guestFromReq['phone']);
                }


                $product->addGuest($guest);
            }
        }
        return $product;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Product::class == $type;
    }
}