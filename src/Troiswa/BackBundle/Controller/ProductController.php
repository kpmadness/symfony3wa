<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Tests\Normalizer\PropertyDummy;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Form\ProductType;
use Troiswa\BackBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductController extends Controller
{

    public function displayProductAction()
    {
        //$date=dump($products);
        $em=$this->getDoctrine()->getManager();
        $products = $em->getRepository('TroiswaBackBundle:Product')
                        ->findAll();

        //dump($products);
        //die;
        return $this->render("TroiswaBackBundle:Product:product.html.twig", ["products" => $products]);
    }

    public function addProductAction(Request $request)
    {

        // lève une exception sur l'accès à une page en fonction du rôle
//        if (!$this->get('security.context')->isGranted('ROLE_ADMIN'))
//        {
//            throw $this->createAccessDeniedException('Vous ne pouvez pas accéder à cette page');
//        }

        $product=new Product();

        //$formProduct = $this->createForm(new ProductType(), null , array("attr" => array("novalidate" => "novalidate")));

        $formProduct = $this->createForm(new ProductType(),$product);

        //dump($product);

        // hydrate le formulaire avec les informations stockées dans S_POST
        $formProduct->handleRequest($request);

//        dump($formProduct);
//        die();

        if($formProduct->isValid()) {
            $em=$this->getDoctrine()->getManager();

            $cover=$product->getCover();
            $cover->setAlt($product->getTitle());
//            $cover->upload();

//            $em->persist($cover);
            $em->persist($product);
            $em->flush();


            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre produit a bien été crée");

            return $this->redirectToRoute('troiswa_back_product');

        }

        return $this->render("TroiswaBackBundle:Product:add-product.html.twig",array("formProduct" =>$formProduct->createView()));
    }

    /**
     *
     */
// @Security("has_role('ROLE_ADMIN')")
    public function updateProductAction($idprod, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getRepository('TroiswaBackBundle:Product')
            ->find($idprod);


        if(empty($product) or $product==null){
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        $formProduct = $this->createForm(new ProductType(),$product);

        $formProduct->handleRequest($request);

        if($formProduct->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $cover=$product->getCover();
            $cover->setAlt($product->getTitle());

//            $tag=$product->getTag();
//            dump($tag);
            //$cover->upload();



//            $em->persist($cover);

            $em->flush();

            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre produit a bien été modifié");

            return $this->redirectToRoute('troiswa_back_product');
        }

        return $this->render("TroiswaBackBundle:Product:add-product.html.twig",array("formProduct" =>$formProduct->createView()));
    }

    public function deleteProductAction($idprod,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getRepository('TroiswaBackBundle:Product')
            ->find($idprod);

        $em->remove($product);
        $em->flush();

        // affichage du message du succès d'envoi du message
        $this->get('session')->getFlashBag()->add('success', "Votre produit a bien été supprimé");

        return $this->redirectToRoute('troiswa_back_product');
    }


    public function displayInfoProductAction($idprod)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getRepository('TroiswaBackBundle:Product')
            ->find($idprod);

        // on teste si le produit existe
        if(empty($product) or $product==null){
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        //die(dump($product));

        return $this->render("TroiswaBackBundle:Product:info-product.html.twig", ["product" => $product]);
    }

    public function displayActiveProductAction()
    {

        $em=$this->getDoctrine()->getManager();
        $products= $em->getRepository('TroiswaBackBundle:Product')
            ->findBy(array('active' => 1), array('price' => 'ASC'), 2);


//        dump($product);
//        die();

        return $this->render("TroiswaBackBundle:Product:product.html.twig", ["products" => $products]);

    }

    public function displayLimitNbProductAction(Request $request)
    {
        $limit = intval($request->query->get("nb"));
        if ($limit == 0)
        {
            $limit = null;
        }

        $em=$this->getDoctrine()->getManager();
        $products= $em->getRepository('TroiswaBackBundle:Product')
            ->findBy(array(), array('price' => 'ASC'), $limit);

//        dump($product);
//        die();

        return $this->render("TroiswaBackBundle:Product:product.html.twig", ["products" => $products]);

    }

    public function displayVisibleProductAction($idprod,$action)
    {
        $em=$this->getDoctrine()->getManager();
        $product= $em->getRepository('TroiswaBackBundle:Product')
            //->findOneBy(array('id' => $idprod));
            ->find($idprod);


        if($product==null){
            throw new NotFoundHttpException("Oups, ce produit n'existe pas !!!");
        }

//        dump($product);
//        die;

        if($product->getActive()==false){
            $product->setActive($action);
        }else {
            $product->setActive($action);
        }

//        dump($product);
//        die();

        $em->persist($product);
        $em->flush();

        return $this->redirectToRoute("troiswa_back_product");
    }

    public function displayErrorProductAction()
    {

        $em=$this->getDoctrine()->getManager();

        $product=$em->getRepository('TroiswaBackBundle:Product')
            ->findBy(array(),array('title' => 'ASC','price' => 'ASC'));

//        dump($category);
//        die();

        return $this->render("TroiswaBackBundle:Product:error404-product.html.twig", ["product" => $product]);
    }

}
