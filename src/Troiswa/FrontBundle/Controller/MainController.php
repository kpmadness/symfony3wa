<?php

namespace Troiswa\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MainController extends Controller
{
    public function indexAction()
    {

        return $this->render("TroiswaFrontBundle:Main:index.html.twig");

    }
}
