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


    public function displayProductByCategoryAction($idcateg){

        $em=$this->getDoctrine()->getManager();

        $products=$em->getRepository('TroiswaBackBundle:Product')->findProductByCategory($idcateg);
//
//
//        dump($products);
//        die();

        return $this->render("TroiswaFrontBundle:Main:category-page.html.twig", ["products" => $products]);


    }
}
