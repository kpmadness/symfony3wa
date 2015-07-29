<?php

namespace Troiswa\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Product;
use Troiswa\FrontBundle\Entity\ClientFosUser;
use Troiswa\FrontBundle\Entity\Comment;
use Troiswa\FrontBundle\Form\CommentType;


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

        return $this->render("TroiswaFrontBundle:Product:product-page.html.twig", ["product" => $product]);

    }


    public function displayProductByCategoryAction($idcateg){

        $em=$this->getDoctrine()->getManager();

        $products=$em->getRepository('TroiswaBackBundle:Product')->findProductByCategory($idcateg);

        return $this->render("TroiswaFrontBundle:Category:category-page.html.twig", ["products" => $products]);


    }

    public function displayCommentFormProductAction(Product $product, Request $originalRequest, Request $request){

        $comment=new Comment();

        $comment->setProduct($product);
//        dump($this->getUser());
//        die;
        $author=$this->getUser();

        $formComment = $this->createForm(new CommentType(), $comment);

        // hydrate le formulaire avec les informations stockées dans S_POST
        $formComment->handleRequest($originalRequest);

//        dump($idprod);
//        die();

        if($formComment->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $comment->setAuthor($author);
            $comment->setProduct($product);
            $em->persist($comment);
            $em->flush();

            // affichage du message du succès d'envoi du commentaire
            $this->get('session')->getFlashBag()->add('success', "Votre commentaire a bien été enregistré");

            return $this->forward('TroiswaFrontBundle:Main:displayCommentFormProduct', ['product' => $product, 'originalRequest' => $request]);
        }

        return $this->render("TroiswaFrontBundle:Product:product-comment.html.twig",array("formComment" =>$formComment->createView()));
    }
}
