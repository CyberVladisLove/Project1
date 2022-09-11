<?php


namespace App\Serializer\Normalizer;



use App\Entity\Party;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PartyNormalizer implements NormalizerInterface
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
            'name' => $object->getName(),
            'date' => $object->getDateAt(),
            'createdAt' => $object->getCreatedAt(),
            'guests' =>  $object->getGuests()->toArray(),
            'author' => $object->getAuthor(),

        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Party;
    }
}