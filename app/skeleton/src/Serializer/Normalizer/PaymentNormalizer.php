<?php

namespace App\Serializer\Normalizer;

use App\Entity\Payment;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaymentNormalizer implements NormalizerInterface
{
    /**
     * @param Payment $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'date' => $object->getDate(),
            'fromGuest' => $object->getToGuest() ? [
                'id' => $object->getFromGuest()->getId(),
                'name' => $object->getFromGuest()->getName(),
                'phone' => $object->getFromGuest()->getPhone()
            ]:null,
            'toGuest' => $object->getToGuest() ? $object->getToGuest()->getId() : null,
            'value' => $object->getValue(),
            'author' => $object->getAuthor(),

        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Payment;
    }

}