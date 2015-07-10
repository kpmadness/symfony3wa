<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

//        $category = new Category();
//        $category->setTitle('Billetterie');
//        $category->setDescription('les places pour les spectacles/concerts/théâtres à prix choc !!!');
//        $category->setPosition(6);
//
//
//        $manager->persist($category);
//        $manager->flush();
    }
}
