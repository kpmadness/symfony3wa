<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Tests\Normalizer\PropertyDummy;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Form\BrandType;
use Troiswa\BackBundle\Entity\Brand;


class BrandController extends Controller
{

    public function displayBrandAction()
    {
        //$date=dump($products);
        $em=$this->getDoctrine()->getManager();
        $brands = $em->getRepository('TroiswaBackBundle:Brand')
                        ->findAll();

        //dump($products);
        //die;
        return $this->render("TroiswaBackBundle:Brand:brand.html.twig", ["brands" => $brands]);
    }

    public function addBrandAction(Request $request)
    {
        $brand=new Brand();

        /*$date=time();

        $brand->setDateCreated($date);*/

        $formBrand = $this->createForm(new BrandType(),$brand);

        // hydrate le formulaire avec les informations stockées dans S_POST
        $formBrand->handleRequest($request);

        if($formBrand->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush();


            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre marque a été créee avec succès !!!");

            return $this->redirectToRoute('troiswa_back_brand');

        }

        return $this->render("TroiswaBackBundle:Brand:add-brand.html.twig",array("formBrand" =>$formBrand->createView()));
    }


    public function updateBrandAction($idbrand, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $brand = $em->getRepository('TroiswaBackBundle:Brand')
            ->find($idbrand);

        if(empty($brand) or $brand==null){
            throw $this->createNotFoundException("La marque n'existe pas");
        }

        $formBrand = $this->createForm(new BrandType(),$brand);

        $formBrand->handleRequest($request);

        if($formBrand->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em->flush();

            // affichage du message du succès d'envoi du message
            $this->get('session')->getFlashBag()->add('success', "Votre marque a bien été modifié");

            return $this->redirectToRoute('troiswa_back_brand');
        }

        return $this->render("TroiswaBackBundle:Brand:add-brand.html.twig",array("formBrand" =>$formBrand->createView()));
    }

    public function deleteBrandAction($idbrand,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $brand = $em->getRepository('TroiswaBackBundle:Brand')
            ->find($idbrand);

        $em->remove($brand);
        $em->flush();

        // affichage du message du succès d'envoi du message
        $this->get('session')->getFlashBag()->add('success', "Votre marque a bien été supprimée");

        return $this->redirectToRoute('troiswa_back_brand');
    }


    public function displayInfoBrandAction($idbrand)
    {
        $em=$this->getDoctrine()->getManager();
        $brand = $em->getRepository('TroiswaBackBundle:Brand')
            ->find($idbrand);

        // on teste si le produit existe
        if(empty($brand) or $brand==null){
            throw $this->createNotFoundException("La marque n'existe pas");
        }

        return $this->render("TroiswaBackBundle:Brand:info-brand.html.twig", ["brand" => $brand]);
    }

}
