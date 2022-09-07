<?php


namespace App\Controller\Api;


use App\Repository\GuestRepository;
use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/api/party')]
class PartyController extends AbstractController
{
    #[Route('/', name: 'api_party_index', methods: ['GET'])]
    public function index(PartyRepository $partyRepository, NormalizerInterface $normalizer):Response
    {
        $parties = $partyRepository->findAll();
        return $this->json($normalizer->normalize($parties, 'json', [
            'groups' => ['indexParty'],
        ]));
    }
}