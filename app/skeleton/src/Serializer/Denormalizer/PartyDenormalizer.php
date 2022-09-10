<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Cheque;
use App\Entity\Party;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PartyDenormalizer extends AbstractDenormalizer
{


    public function denormalize($data, string $type, string $format = null, array $context = [])
    {

    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Party::class == $type;
    }
}