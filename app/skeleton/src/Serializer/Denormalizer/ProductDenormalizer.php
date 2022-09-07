<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Cheque;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductDenormalizer implements DenormalizerInterface
{
    /**
     * ProductDenormalizer constructor.
     */
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {

    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Product::class == $type;
    }
}