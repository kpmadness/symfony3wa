<?php

namespace Troiswa\FrontBundle\Util;

use Troiswa\BackBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

class Cart
{

    private $session;

    private $em;

    public function __construct(Session $serviceSession, EntityManager $em)
    {
        $this->session = $serviceSession;
        $this->em = $em;
    }

    public function add(Product $product, $qty = 1)
    {
        if ($qty > 0)
        {
            //$session = $request->getSession();

            if ($this->session->get('cart'))
            {
                $cart = json_decode($this->session->get('cart'), true);
            }
            else
            {
                $cart = [];
            }

            if (array_key_exists($product->getId(), $cart))
            {
                $qty += $cart[$product->getId()]['quantity'];
            }

            $cart[$product->getId()] = ['quantity' => $qty];

            $this->session->set('cart', json_encode($cart));

        }
    }

    public function remove(Product $product)
    {

        $cart=json_decode($this->session->get('cart'),true);

        $qty = $cart[$product->getId()]['quantity'];

        if (array_key_exists($product->getId(), $cart))
        {
               unset($cart[$product->getId()]);
        }

        $this->session->set('cart', json_encode($cart));

//        dump($cart);
//        die();
    }

    public function increaseQuantity(Product $product)
    {
        $cart=json_decode($this->session->get('cart'),true);

        $qty = $cart[$product->getId()]['quantity'];

        if (array_key_exists($product->getId(), $cart))
        {
            $qty += $cart[$product->getId()]['quantity'];
        }

        $this->session->set('cart', json_encode($cart));

        dump($cart);
        die();

    }

    public function decreaseQuantity(Product $product)
    {
        $cart=json_decode($this->session->get('cart'),true);

        $qty = $cart[$product->getId()]['quantity'];

        if (array_key_exists($product->getId(), $cart))
        {
            echo 'tata';
            dump($cart);
            die();
            $qty -= $cart[$product->getId()]['quantity'];
        }

        $this->session->set('cart', json_encode($cart));

        dump($cart);
        die();

    }

    public function getProducts()
    {

        $cart=json_decode($this->session->get('cart'),true);

        $products= [];

        if ($cart) {
            $em = $this->getDoctrine()->getManager();
            $idProducts = array_keys($cart);
            $products = $em->getRepository('TroiswaBackBundle:Product')->findProductCartFront($idProducts);
        }

        return $products;

    }

}