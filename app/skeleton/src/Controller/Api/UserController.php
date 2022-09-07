<?php


namespace App\Controller\Api;


use App\Repository\GuestRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/api/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'api_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, NormalizerInterface $normalizer):Response
    {
        return $this->json($normalizer->normalize($userRepository->findAll(), 'json', [
            'groups' => ['indexUser'],
        ]));
    }
}