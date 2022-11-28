<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Services\CartService;
use App\Services\ProductsService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path:'/cart')]
class CartController extends AbstractController
{
    private $doctrine;
    private $repository;
    private $cart;
    public  function __construct(ManagerRegistry $doctrine, CartService $cart)
    {
        $this->doctrine = $doctrine;
        $this->repository = $doctrine->getRepository(Producto::class);
        $this->cart = $cart;
    }

    #[Route('/', name: 'cart')]
    public function cart(): Response
    {
        $products = $this->repository->getFromCart($this->cart);
        //hay que añadir la cantidad de cada producto
        $items = [];
        $totalCart = 0;
        foreach($products as $product){
            $item = [
                "id"=> $product->getId(),
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "photo" => $product->getPhoto(),
                "quantity" => $this->cart->getCart()[$product->getId()]
            ];
            $totalCart += $item["quantity"] * $item["price"];
            $items[] = $item;
        }

        return $this->render('cart/index.html.twig', ['items' => $items, 'totalCart' => $totalCart]);
    }




    #[Route('/add/{id}', name: 'cart_add', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function cart_add(int $id): Response{
        $product = $this->repository->find($id);
        if (!$product)
            return new JsonResponse("[]", Response::HTTP_NOT_FOUND);

        $this->cart->add($id, 1);
        
        $data = [
            "id"=> $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "photo" => $product->getPhoto(),
            "quantity" => $this->cart->getCart()[$product->getId()]
        ];
        return new JsonResponse($data, Response::HTTP_OK);

    }

    

}