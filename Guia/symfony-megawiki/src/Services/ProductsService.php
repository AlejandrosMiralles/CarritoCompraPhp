<?php
namespace App\Services;
   
use App\Entity\Producto;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
   
class ProductsService extends AbstractController{
    private $doctrine;
   
    public function __construct(ManagerRegistry $doctrine)
    {
        //Como hace falta acceder a ManagerRegistry lo inyectamos en el constructor
        $this->doctrine = $doctrine;
    }
    public function getProducts(): ?array{
        $repository = $this->doctrine->getRepository(Producto::class);
        return $repository->findAll();
    }
}
