<?php


namespace App\Controller\Api;


use App\Repository\GuestRepository;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/api/guest')]
class GuestController extends AbstractController
{
    #[Route('/', name: 'api_guest_index', methods: ['GET'])]
    public function index(GuestRepository $guestRepository, NormalizerInterface $normalizer):Response
    {
        $guests = $guestRepository->findAll();
        return $this->json($normalizer->normalize($guests, 'json'));
    }
}

