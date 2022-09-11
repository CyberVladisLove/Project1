<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Cheque;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserDenormalizer extends AbstractDenormalizer
{


    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $user = $this->getObject(User::class, $context);

        if (key_exists('email', $data)) $user->setEmail($data['email']);


        return $user;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return User::class == $type;
    }
}