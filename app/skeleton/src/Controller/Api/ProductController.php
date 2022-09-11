<?php


namespace App\Controller\Api;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'api_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($normalizer->normalize($productRepository->findAll(), 'json'));
    }

    #[Route('/new', name: 'api_product_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $newProduct = $serializer->deserialize($request->getContent(), Product::class, 'json');

        $entityManager->persist($newProduct);
        $entityManager->flush();

        return $this->json($newProduct, 201);
    }

    #[Route('/{id}/edit', name: 'api_product_edit', methods: ['POST'])]
    public function edit(Product $oldPayment, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $editedProduct = $serializer->deserialize($request->getContent(), Product::class, 'json', ['oldEntity' => $oldPayment]);

        $entityManager->flush();

        return $this->json($editedProduct, 201);
    }
}