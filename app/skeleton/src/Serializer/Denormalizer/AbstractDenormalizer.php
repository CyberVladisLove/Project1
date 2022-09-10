<?php


namespace App\Serializer\Denormalizer;


use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractDenormalizer implements DenormalizerInterface
{
    //Все ради метода $this->jsonToEntity
    //Позволяет удобно и без кучи кода создавать дочерние сущности в денормалайзерах

    /**
     * AbstractDenormalizer constructor.
     */
    public function __construct
    (
        protected EntityManagerInterface $em,
        protected SerializerInterface $serializer
    ){}

    public function jsonToEntity($json, string $className) : mixed
    {
        return null;//$this->serializer->deserialize($json, $className, 'json');
    }

    abstract function denormalize(mixed $data, string $type, string $format = null, array $context = []);
    abstract function supportsDenormalization(mixed $data, string $type, string $format = null);



}