<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class CartService{
    private const KEY = '_cart';
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function getSession()
    {
        return $this->requestStack->getSession();
    }
    public function getCart(): array {
        return $this->getSession()->get(self::KEY, []);
    }

    public function update(int $id, $quantity ){
        //https://symfony.com/doc/current/session.html
        $cart = $this->getCart();
        //Sólo añadimos si no lo está 
        if (!array_key_exists($id, $cart))
            $cart[$id] = $quantity;
        $this->getSession()->set(self::KEY, $cart);
    }


    public function add(int $id, int $quantity = 1){
        $this->update($id, $quantity);
    }

    public function delete(int $id){
        $cart = $this->getCart();
        unset($cart[$id]);
    }
}
