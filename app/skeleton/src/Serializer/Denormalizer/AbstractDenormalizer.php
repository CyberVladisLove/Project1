<?php


namespace App\Serializer\Denormalizer;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractDenormalizer implements DenormalizerInterface
{


    /**
     * AbstractDenormalizer constructor.
     */
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    protected function getObject($className, array $context = []){
        if(key_exists('oldEntity', $context)){
            $entity = $context['oldEntity'];
        }
        else{
            $entity = new $className();
        }
        return $entity;
    }
    abstract function denormalize(mixed $data, string $type, string $format = null, array $context = []);
    abstract function supportsDenormalization(mixed $data, string $type, string $format = null);


}