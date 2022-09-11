<?php


namespace App\Serializer\Normalizer;


use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductNormalizer implements NormalizerInterface
{

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'price' => $object->getPrice(),
            'count' => $object->getCount(),
            'cheque' => $object->getCheque()? [
                'id' => $object->getCheque()->getId(),
                'shop' => $object->getCheque()->getShop(),
                'customerGuest' => $object->getCheque()->getCustomerGuest()->getName()
            ]:null,
            'author' => $object->getAuthor(),

        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Product;
    }
}