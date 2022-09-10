<?php


namespace App\Controller\Api;


use App\Entity\Cheque;
use App\Entity\Guest;
use App\Repository\GuestRepository;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/guest')]
class GuestController extends AbstractController
{
    #[Route('/', name: 'api_guest_index', methods: ['GET'])]
    public function index(GuestRepository $guestRepository, NormalizerInterface $normalizer):Response
    {
        $guests = $guestRepository->findAll();
        return $this->json($normalizer->normalize($guests, 'json'));
    }

    #[Route('/new', name: 'api_guest_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $guest = $serializer->deserialize($request->getContent(), Guest::class, 'json');

        $entityManager->persist($guest);
        $entityManager->flush();
        return $this->json($guest, 201);
    }

    #[Route('/{id}/edit', name: 'api_guest_edit', methods: ['POST'])]
    public function edit(Guest $oldGuest, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $guestFromReq = $serializer->deserialize($request->getContent(), Cheque::class, 'json', ['oldEntity' => $oldGuest]);

        $entityManager->flush();

        return $this->json($guestFromReq, 201);
    }
}

