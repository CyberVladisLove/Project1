<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Guest;
use App\Entity\Product;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GuestDenormalizer extends AbstractDenormalizer
{

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $guest = $this->getObject(Guest::class, $context);

        $this->setSimpleFields($guest, $data);
        $this->setObjectFields($guest, $data, $this->em);

        return $guest;
    }

    public static function setSimpleFields($object, $data)
    {
        if (key_exists('phone', $data)) $object->setPhone($data['phone']);
        if (key_exists('name', $data)) $object->setName($data['name']);
    }

    public static function setObjectFields($object, $data, EntityManagerInterface $em)
    {
        $guest = $object;
        if (key_exists('products', $data)){

            foreach($data['products'] as $productFromReq){

                if (key_exists('id', $productFromReq)){
                    $product = $em->find(Product::class, $productFromReq['id']);
                    if($product == null){
                        $product = new Product();
                        ProductDenormalizer::setSimpleFields($product, $productFromReq);
                    }
                }
                else{
                    $product = new Product();
                    ProductDenormalizer::setSimpleFields($product, $productFromReq);
                }
                //считаю что если в запросе будет массив продуктов,
                //то их просто добавляю в гостя, а не заменяю старые на новые
                $guest->addProduct($product);
            }

        }
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Guest::class == $type;
    }
}