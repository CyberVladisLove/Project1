<?php


namespace App\Serializer\Denormalizer;


use App\Entity\Cheque;
use App\Entity\Guest;
use App\Entity\Party;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class PartyDenormalizer extends AbstractDenormalizer
{


    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $party = $this->getObject(Party::class, $context);

        if (key_exists('name', $data)) $party->setName($data['name']);
        if (key_exists('location', $data)) $party->setLocation($data['location']);

        if (key_exists('guests', $data)){

            foreach($data['guests'] as $guestFromReq){
                if (key_exists('id', $guestFromReq)){
                    $guest = $this->em->find(Guest::class, $guestFromReq['id']);
                    if($guest == null){
                        $guest = new Guest();
                        $guest->setName($guestFromReq['name']);
                        $guest->setPhone($guestFromReq['phone']);
                    }
                }
                else{
                    $guest = new Guest();
                    $guest->setName($guestFromReq['name']);
                    $guest->setPhone($guestFromReq['phone']);
                }
                //считаю что если в запросе будет массив гостей,
                //то их просто добавляю в тусовку, а не заменяю старых на новых
                $party->addGuest($guest);
            }

        }
        return $party;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Party::class == $type;
    }
}