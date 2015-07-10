<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

//permettant de charger des éléments en ligne de commande
//php app/console doctrine:fixtures:load
//php app/console doctrine:fixtures:load --append


//        $product = new Product();
//        $product->setTitle('Caméscope');
//        $product->setDescription('caméscope CANON ultra-design - top de la technologie');
//        $product->setPrice(499);
//        $product->setQuantity(15);
//        $product->setActive(1);
//
//        $manager->persist($product);
//        $manager->flush();
    }
}
