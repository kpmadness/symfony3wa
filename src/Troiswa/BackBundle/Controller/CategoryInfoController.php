<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryInfoController extends Controller
{

    public function displayInfoCategoryAction($idcat)
    {

        $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];

        if(!isset($categories[$idcat])){
            throw $this->createNotFoundException("NO");
        }

        $onecategory=$categories[$idcat];

        return $this->render("TroiswaBackBundle:Static:categoryInfo.html.twig", ["category" => $onecategory]);
    }





}
