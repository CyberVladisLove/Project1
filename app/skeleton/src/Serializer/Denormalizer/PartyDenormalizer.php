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

        $this->setSimpleFields($party, $data);
        $this->setObjectFields($party, $data, $this->em);

        return $party;
    }


    public static function setSimpleFields($object, $data)
    {
        if (key_exists('name', $data)) $object->setName($data['name']);
        if (key_exists('location', $data)) $object->setLocation($data['location']);
    }

    public static function setObjectFields($object, $data, EntityManagerInterface $em)
    {
        $party = $object;
        if (key_exists('guests', $data)){

            foreach($data['guests'] as $guestFromReq){
                if (key_exists('id', $guestFromReq)){
                    $guest = $em->find(Guest::class, $guestFromReq['id']);
                    if($guest == null){
                        $guest = new Guest();
                        GuestDenormalizer::setSimpleFields($guest, $guestFromReq);
                    }
                }
                else{
                    $guest = new Guest();
                    GuestDenormalizer::setSimpleFields($guest, $guestFromReq);
                }
                //считаю что если в запросе будет массив гостей,
                //то их просто добавляю в тусовку, а не заменяю старых на новых
                $party->addGuest($guest);
            }
        }
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Party::class == $type;
    }
}