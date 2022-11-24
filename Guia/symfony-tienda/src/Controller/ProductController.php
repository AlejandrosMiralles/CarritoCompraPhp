<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
