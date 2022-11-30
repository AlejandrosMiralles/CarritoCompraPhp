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
    public  function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $doctrine->getRepository(Producto::class);
    }

    #[Route('/', name: 'cart')]
    public function cart(CartService $cart): Response
    {
        $products = $this->repository->getFromCart($cart);
        //hay que añadir la cantidad de cada producto
        $items = [];
        $totalCart = 0;
        foreach($products as $product){
            $item = [
                "id"=> $product->getId(),
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "photo" => $product->getPhoto(),
                "quantity" => $cart->getCart()[$product->getId()]
            ];
            $totalCart += $item["quantity"] * $item["price"];
            $items[] = $item;
        }

        return $this->render('cart/index.html.twig', ['items' => $items, 'totalCart' => $totalCart]);
    }




    #[Route('/add/{id}', name: 'cart_add', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function cart_add(int $id, CartService $cart): Response{
        $product = $this->repository->find($id);
        if (!$product)
            return new JsonResponse("[]", Response::HTTP_NOT_FOUND);

        $cart->add($id, 1);
        
        $data = [
            "id"=> $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "photo" => $product->getPhoto()
        ];
        return new JsonResponse($data, Response::HTTP_OK);

    }

    #[Route('/update/{id}/{quantity}', name: 'cart_update', methods: ['GET', 'POST'], requirements: ['id' => '\d+', 'quantity' => '\d+'])]
    public function cart_update(int $id, int $quantity, CartService $cart): Response{
        $product = $this->repository->find($id);
        if (!$product)
            return new JsonResponse("[]", Response::HTTP_NOT_FOUND);

        $cart->update($id, $quantity);
        
        $data = [
            "id"=> $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "photo" => $product->getPhoto(),
            "quantity" => $cart->getCart()[$product->getId()]
        ];
        return new JsonResponse($data, Response::HTTP_OK);

    }

    #[Route('/delete/{id}', name: 'cart_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function cart_delete(int $id, CartService $cart): Response{
        $product = $this->repository->find($id);
        if (!$product)
            return new JsonResponse("[]", Response::HTTP_NOT_FOUND);

        $cart->delete($id);
        
        $data = [
            "totalCart" => count($cart->getCart())
        ];

        return new JsonResponse($data, Response::HTTP_OK);

    }

    #[Route('/totalItems', name: 'cart_totalItems', methods: ['POST', 'GET'])]
    public function totalItems(CartService $cart): Response{
        $data = [
            "totalCart" => count($cart->getCart())
        ];

        return new JsonResponse($data, Response::HTTP_OK);

    }
    

    

}