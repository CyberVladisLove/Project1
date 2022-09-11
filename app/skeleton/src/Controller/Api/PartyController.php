<?php


namespace App\Controller\Api;


use App\Entity\Cheque;
use App\Entity\Guest;
use App\Entity\Party;
use App\Repository\GuestRepository;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/party')]
class PartyController extends AbstractController
{
    #[Route('/', name: 'api_party_index', methods: ['GET'])]
    public function index(PartyRepository $partyRepository, NormalizerInterface $normalizer):Response
    {
        $parties = $partyRepository->findAll();
        return $this->json($normalizer->normalize($parties, 'json'));
    }

    #[Route('/new', name: 'api_party_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $newParty = $serializer->deserialize($request->getContent(), Party::class, 'json');

        $entityManager->persist($newParty);
        $entityManager->flush();
        return $this->json($newParty, 201);
    }

    #[Route('/{id}/edit', name: 'api_party_edit', methods: ['POST'])]
    public function edit(Party $oldParty, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $editedParty = $serializer->deserialize($request->getContent(), Party::class, 'json', ['oldEntity' => $oldParty]);

        $entityManager->flush();

        return $this->json($editedParty, 201);
    }
}