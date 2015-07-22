<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Product;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
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
//
//        //$product->setCateg($this->getReference('refcat'));
//        $product->setBrand($this->getReference('refbd'));
//
//        $manager->persist($product);
//        $manager->flush();
    }

    public function getOrder()
    {
//        return 2;
    }
}
