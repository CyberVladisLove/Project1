<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Guest;
use App\Entity\Product;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class GuestDenormalizer extends AbstractDenormalizer
{

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        if(key_exists('oldEntity', $context)){
            $guest = $context['oldEntity'];
        }
        else{
            $guest = new Guest();
        }

        if (key_exists('user', $data)) $guest->setByUser($data['user']);
        if (key_exists('phone', $data)) $guest->setPhone($data['phone']);
        if (key_exists('products', $data)){

            $products = new ArrayCollection();
            foreach($data['products'] as $productFromReq){
                if (key_exists('id', $productFromReq)){
                    $product = $this->em->find(Product::class,$productFromReq['id']);
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
                $products->add($product);
            }
            $guest->setProducts($products);
        }





        return $guest;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Guest::class == $type;
    }

}
