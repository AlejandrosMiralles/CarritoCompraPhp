<?php

namespace App\Controller;

use App\Entity\Producto;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function product(): Response{
        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/price', name: 'price')]
    public function price(): Response{
        return $this->render('product/price.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    public function productTemplate(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Producto::class);
        $products = $repository->findAll();
        return $this->render('partials/_product.html.twig', 
            compact('products')
        );
    }
}
