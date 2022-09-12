<?php


namespace App\Serializer\Denormalizer;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractDenormalizer implements DenormalizerInterface
{
    /**
     * AbstractDenormalizer constructor.
     */
    public function __construct(protected EntityManagerInterface $em)
    {
    }
    //позволяет получить редактируемый объект из context или создать новый
    protected function getObject($className, array $context = []){

        if(key_exists('oldEntity', $context)){
            $object = $context['oldEntity'];
        }
        else{
            $object = new $className();
        }
        return $object;
    }
    //методы избавляющие от копипасты кода при денормализации
    abstract static function setSimpleFields(mixed $object, $data);
    //abstract static function setObjectFields($object, $data, EntityManagerInterface $em);

    abstract function denormalize(mixed $data, string $type, string $format = null, array $context = []);
    abstract function supportsDenormalization(mixed $data, string $type, string $format = null);


}