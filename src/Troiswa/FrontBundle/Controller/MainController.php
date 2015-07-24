<?php

namespace Troiswa\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Product;


class MainController extends Controller
{
    public function indexAction()
    {

        return $this->render("TroiswaFrontBundle:Main:index.html.twig");

    }

    public function displayCategoryMenuAction()
    {
        $em=$this->getDoctrine()->getManager();
        $category = $em->getRepository('TroiswaBackBundle:Category')->findCategoryByPosition();

        return $this->render("TroiswaFrontBundle:Globals:sidebar.html.twig", ["category" => $category]);
    }

    public function displayProductFrontSliderAction()
    {
        $em=$this->getDoctrine()->getManager();

        $product=$em->getRepository('TroiswaBackBundle:Product')->findProductToDisplayFront(4);

        return $this->render("TroiswaFrontBundle:Main:slider.html.twig", ["products" => $product]);

    }

    public function displayProductWithMaxTagAction()
    {
        $em=$this->getDoctrine()->getManager();

        $product=$em->getRepository('TroiswaBackBundle:Product')->findProductWithMaxTag();

        return $this->render("TroiswaFrontBundle:Main:products-front.html.twig", ["products" => $product]);

    }

    public function displayPageProductFrontAction($idprod)
    {
        $em=$this->getDoctrine()->getManager();

        $product=$em->getRepository('TroiswaBackBundle:Product')->find($idprod);


        return $this->render("TroiswaFrontBundle:Main:product-page.html.twig", ["product" => $product]);

    }


    public function addCartAction(Product $product, Request $request)
    {
        // Récupération des informations du formulaire d'ajout au panier
        $qty = $request->request->getInt('qty');

        if ($qty > 0)
        {
            $session = $request->getSession();


            if ($session->get('cart'))
            {
                $cart = (array)json_decode($session->get('cart'));
            }
            else
            {
                $cart = [];
            }

            $contain = false;

            foreach($cart as $oneProduct)
            {
                // Produit déjà dans le panier
                if ($oneProduct->id_product == $product->getId())
                {
                    echo 'ok';
                    // Ajout de la quantité à l'ancienne
                    $oneProduct->quantity = $oneProduct->quantity + $qty;
                    $contain = true;
                    break;
                }
            }

            if ($contain == false)
            {
                array_push($cart, ['id_product' => $product->getId(), 'quantity' => $qty]);
            }

            $session->set('cart', json_encode($cart));

        }

        return $this->redirectToRoute('troiswa_front_cart');

    }

    // methode 2
//    public function addCartAction(Product $product, Request $request)
//    {
//        // Récupération des informations du formulaire d'ajout au panier
//        $qty = $request->request->getInt('qty');
//
//        if ($qty > 0)
//        {
//            $session = $request->getSession();
//            $session->remove('cart');
//
//            if ($session->get('cart'))
//            {
//                $cart = json_decode($session->get('cart'), true);
//            }
//            else
//            {
//                $cart = [];
//            }
//
//            if (array_key_exists($product->getId(), $cart))
//            {
//                $qty = $qty +  $cart[$product->getId()]['quantity'];
//            }
//
//            $cart[$product->getId()] = ['quantity' => $qty];
//
//            $session->set('cart', json_encode($cart));
//
//        }
//
//        return $this->redirectToRoute('troiswa_front_cart');
//
//    }

    public function cartAction(Request $request)
    {
        $session = $request->getSession();
//        dump($session->get('cart'));
//        dump(json_decode($session->get('cart')));
        $cart = (array)json_decode($session->get('cart')); // LIGNE PERMETTANT DE RECUP LE PANIER

//
//        dump($cart);
//        die();

        $arrayID=array();

        // création d'un tableau vide qui contiendra tous les id_product
        // On parcour $cart
        // On ajoute l'id_product au tableau précédemment créé
        foreach($cart as $key => $value){

            array_push($arrayID, $cart[$key]->id_product);
        }

//        dump($arrayID);
//        die();

        // Si le tableau précédemment crée n'est pas vide
        // Utilisation de implode : http://php.net/manual/fr/function.implode.php
        // Implode permet de transformer un tableau en chaîne de caractère
        $tab=$arrayID;


//        dump($tab);
//        die();

        $em=$this->getDoctrine()->getManager();

        $cart=$em->getRepository('TroiswaBackBundle:Product')->findProductCartFrontAction($tab);

        return $this->render("TroiswaFrontBundle:Main:cart.html.twig", ["cart" => $cart]);

    }

    // methode 2
//    public function cartAction(Request $request)
//    {
//        $session = $request->getSession();
//        $cart = json_decode($session->get('cart'), true);
//        $products = [];
//
//        if ($cart)
//        {
//            $em = $this->getDoctrine()->getManager();
//            $idProducts = array_keys($cart);
//            $products = $em->getRepository('')->fonction($idProducts);
//        }
//
//        return $this->render('', ['products' => $products, 'panier' => $cart])
//        die;
//    }
}
