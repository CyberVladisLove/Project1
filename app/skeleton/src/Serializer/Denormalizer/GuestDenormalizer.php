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

        if (key_exists('phone', $data)) $guest->setPhone($data['phone']);
        if (key_exists('name', $data)) $guest->setName($data['name']);

        if (key_exists('products', $data)){

            foreach($data['products'] as $productFromReq){
                if (key_exists('id', $productFromReq)){
                    $product = $this->em->find(Product::class, $productFromReq['id']);
                    if($product == null){
                        $product = new Product();
                        $product->setName($productFromReq['name']);
                        $product->setPrice($productFromReq['price']);
                        $product->setCount($productFromReq['count']);
                    }
                }
                else{
                    $product = new Product();
                    $product->setName($productFromReq['name']);
                    $product->setPrice($productFromReq['price']);
                    $product->setCount($productFromReq['count']);
                }
                //считаю что если в запросе будет массив продуктов,
                //то их просто добавляю в гостя, а не заменяю старые на новые
                $guest->addProduct($product);
            }

        }
        return $guest;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Guest::class == $type;
    }
}