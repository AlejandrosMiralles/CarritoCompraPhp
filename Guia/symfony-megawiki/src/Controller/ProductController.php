<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Services\ProductsService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function product(ProductsService $productsService): Response{
        $products = $productsService->getProducts();
        return $this->render('product/product.html.twig', compact('products'));
    }

    #[Route('/product/price', name: 'price')]
    public function price(): Response{
        return $this->render('product/price.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/getJson/{id}', name: 'product_On_Json', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function productOnJson(int $id, ManagerRegistry $doctrine): Response{
        $product = $doctrine->getRepository(Producto::class)->find($id);

        if (!$product)
            return new JsonResponse("[]", Response::HTTP_NOT_FOUND);
        
        $data = [
            "id"=> $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "photo" => $product->getPhoto()
        ];
        return new JsonResponse($data, Response::HTTP_OK);

    }

    
}
