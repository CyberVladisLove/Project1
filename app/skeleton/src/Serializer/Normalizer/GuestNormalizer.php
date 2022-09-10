<?php


namespace App\Serializer\Normalizer;


use App\Entity\Guest;
use App\Entity\Party;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GuestNormalizer implements NormalizerInterface
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
            'phone' => $object->getPhone(),
            'author' => $object->getAuthor(),
            'user' => $object->getByUser(),
            'products' => $object->getProducts()->toArray(),

        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Guest;
    }
}