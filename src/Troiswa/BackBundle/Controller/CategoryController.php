<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Form\CategoryType;
use Troiswa\BackBundle\Entity\Category;

class CategoryController extends Controller
{

    public function displayCategoryAction()
    {
        $em=$this->getDoctrine()->getManager();
        $category = $em->getRepository('TroiswaBackBundle:Category')
            ->findAll();

        return $this->render("TroiswaBackBundle:Category:category.html.twig", ["category" => $category]);
    }

    public function addCategoryAction(Request $request)
    {
        $category=new Category();

        $formCategory = $this->createForm(new CategoryType(),$category);

        // hydrate le formulaire avec les informations stockées dans S_POST
        $formCategory->handleRequest($request);

        if($formCategory->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();


            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre catégorie a bien été créée");

            return $this->redirectToRoute('troiswa_back_category');

        }

        return $this->render("TroiswaBackBundle:Category:add-category.html.twig",array("formCategory" =>$formCategory->createView()));
    }


    public function updateCategoryAction($idcat, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $category = $em->getRepository('TroiswaBackBundle:Category')
            ->find($idcat);

        if(empty($category) || $category==null){
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        $formCategory = $this->createForm(new CategoryType(),$category);

        $formCategory->handleRequest($request);

        if($formCategory->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->flush();

            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre catégorie a bien été modifiée");

            return $this->redirectToRoute('troiswa_back_category');
        }

        return $this->render("TroiswaBackBundle:Category:add-category.html.twig",array("formCategory" =>$formCategory->createView()));
    }

    public function deleteCategoryAction($idcat,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $category = $em->getRepository('TroiswaBackBundle:Category')
            ->find($idcat);

        $em->remove($category);
        $em->flush();

        // affichage du message du succès d'envoi du message
        $this->get('session')->getFlashBag()->add('success', "Votre catégorie a bien été supprimée");

        return $this->redirectToRoute('troiswa_back_category');
    }


    public function displayInfoCategoryAction($idcat)
    {


        $em=$this->getDoctrine()->getManager();
        $category = $em->getRepository('TroiswaBackBundle:Category')
            ->find($idcat);

        // on teste si le produit existe
        if(empty($category) or $category==null){
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        //die(dump($category));

        return $this->render("TroiswaBackBundle:Category:info-category.html.twig", ["category" => $category]);
    }

    public function displayCategoryMenuAction(){

        $em=$this->getDoctrine()->getManager();

        $category=$em->getRepository('TroiswaBackBundle:Category')
            ->findBy(array(),array('position' => 'ASC', 'title' => 'ASC'));

//        dump($category);
//        die();

        return $this->render("TroiswaBackBundle:Category:subMenu-category.html.twig", ["category" => $category]);
    }


}
