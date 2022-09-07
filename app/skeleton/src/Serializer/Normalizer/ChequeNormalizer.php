<?php


namespace App\Serializer\Normalizer;


use App\Entity\Cheque;
use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ChequeNormalizer implements NormalizerInterface
{
    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'date' => $object->getDate(),

            'shop' => $object->getShop(),
            'author' => $object->getAuthor()? [
                'id' => $object->getAuthor()->getId(),
                'name' => $object->getAuthor()->getEmail()
            ]:null,
            'customerGuest' => $object->getCustomerGuest() ? [
                'id' => $object->getCustomerGuest()->getId(),
                'name' => $object->getCustomerGuest()->getName(),
                'phone' => $object->getCustomerGuest()->getPhone()
            ]:null,
            'products' => $object->getProducts()->toArray(),
        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Cheque;
    }
}