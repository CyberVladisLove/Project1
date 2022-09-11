<?php


namespace App\Serializer\Normalizer;


use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
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
            'email' => $object->getEmail(),
            'roles' => $object->getRoles(),
        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof User;
    }
}