<?php


namespace App\Controller\Api;


use App\Entity\Cheque;
use App\Entity\Payment;
use App\Repository\ChequeRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/cheque')]
class ChequeController extends AbstractController
{
    #[Route('/', name: 'api_cheque_index', methods: ['GET'])]
    public function index(ChequeRepository $chequeRepository,NormalizerInterface $serializer): Response
    {
        $cheques = $chequeRepository->findAll();
        return new JsonResponse($serializer->normalize($cheques,'json'));
    }
    #[Route('/new', name: 'api_cheque_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $newCheque = $serializer->deserialize($request->getContent(), Cheque::class, 'json');

        $entityManager->persist($newCheque);
        $entityManager->flush();
        return $this->json($newCheque, 201);
    }

    #[Route('/{id}/edit', name: 'api_cheque_edit', methods: ['POST'])]
    public function edit(Cheque $cheque, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $editedCheque = $serializer->deserialize($request->getContent(), Cheque::class, 'json', ['oldEntity' => $cheque]);

        $entityManager->flush();

        return $this->json($editedCheque, 201);
    }
}