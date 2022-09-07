<?php


namespace App\Controller\Api;


use App\Repository\GuestRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'api_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, NormalizerInterface $normalizer):Response
    {

        return $this->json($normalizer->normalize($productRepository->findAll(), 'json', [
            'groups' => ['indexProduct'],
        ]));
    }
}