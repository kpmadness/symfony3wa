<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function indexAction()
    {
        //dump($request->query->get("page","default"));
        //die('ok');
        return $this->render("TroiswaBackBundle:Main:index.html.twig");
        //return $this->render('TroiswaBackBundle:Default:index.html.twig', array('name' => $name));
    }

    public function  displayTitleProductAction()
    {
        $em = $this->getDoctrine()->getManager();

        $idprod=1;
        $qty=5;

        // prod.title, il cherche en fait dans getTitle, sinon dans isTitle ou hasTitle
        // ou alors il va chercher une méthode title [car title est privé
        // donc non-accessible de l'extérieur]
        $query=$em->createQuery("SELECT prod
                                  FROM TroiswaBackBundle:Product as prod
                                  WHERE prod.quantity >:qty")
                            //->setParameter("idproduit", $idprod)
                            ->setParameter("qty", $qty);
//        WHERE prod.id = :idproduit
        $products=$query->getResult();

//        dump($products);
//        die();

        return $this->render("TroiswaBackBundle:Product:product.html.twig",["products" => $products]);
    }

    public function displayProductByQuantityAction()
    {
        $qty=5;

        $em = $this->getDoctrine()->getManager();
        $productsQuantity=$em->getRepository("TroiswaBackBundle:Product")->findProductByQuantity($qty);

        return $this->render("TroiswaBackBundle:Product:product.html.twig",["products" => $productsQuantity]);

    }

    public function displayProductByActiveAction()
    {
        $active=0;

        $em = $this->getDoctrine()->getManager();
        $productsCriteria=$em->getRepository("TroiswaBackBundle:Product")->findProductByCriteria($active);

        return $this->render("TroiswaBackBundle:Main:index.html.twig",["resultCriteria" => $productsCriteria]);

    }

    public function displayProductGroupByActiveAction()
    {

        $em = $this->getDoctrine()->getManager();
        $productsGroupBy=$em->getRepository("TroiswaBackBundle:Product")->findProductGroupByActive();

        return $this->render("TroiswaBackBundle:Main:index.html.twig",["resultCriteria" => $productsGroupBy]);

    }

    public function displayProductBetweenPriceAction()
    {
        $price=array('min-price' => 10,
                     'max-price'  => 20);

        $em = $this->getDoctrine()->getManager();
        $productsGroupBy=$em->getRepository("TroiswaBackBundle:Product")->findProductBetweenPrice($price);

        return $this->render("TroiswaBackBundle:Main:index.html.twig",["resultCriteria" => $productsGroupBy]);


    }
}
