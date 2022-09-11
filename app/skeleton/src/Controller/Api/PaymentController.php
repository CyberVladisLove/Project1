<?php

namespace App\Controller\Api;

use App\Entity\Guest;
use App\Entity\Payment;
use App\Repository\GuestRepository;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'api_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository, NormalizerInterface $normalizer) :Response
    {
        $payments = $paymentRepository->findAll();
        return $this->json($normalizer->normalize($payments, 'json'));
    }

    #[Route('/new', name: 'api_payment_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $newPayment = $serializer->deserialize($request->getContent(), Payment::class, 'json');

        $entityManager->persist($newPayment);
        $entityManager->flush();

        return $this->json($newPayment, 201);
    }

    #[Route('/{id}/edit', name: 'api_payment_edit', methods: ['POST'])]
    public function edit(Payment $oldPayment, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $editedPayment = $serializer->deserialize($request->getContent(), Payment::class, 'json', ['oldEntity' => $oldPayment]);

        $entityManager->flush();

        return $this->json($editedPayment, 201);
    }
}