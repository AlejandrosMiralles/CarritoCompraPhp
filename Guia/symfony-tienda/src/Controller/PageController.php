<?php

namespace App\Controller;

use App\Entity\Team;
use App\Services\ProductsService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

class PageController extends AbstractController
{
    #[Route('/page', name: 'app_page')]
    public function index(ProductsService $productsService): Response{

        $products = $productsService->getProducts();

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'products' => $products
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response{
        return $this->render('page/about.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response{
        return $this->render('page/contact.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/service', name: 'service')]
    public function service(): Response{
        return $this->render('page/service.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/team', name: 'team')]
    public function team(): Response{
        return $this->render('page/team.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    public function teamTemplate(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();
        return $this->render('partials/_team.html.twig', 
            compact('team')
        );
    }

}
