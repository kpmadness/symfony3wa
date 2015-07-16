<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Category;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
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


//        $this->addReference('refcat', $category);
    }

    public function getOrder()
    {
//        return 1;
    }
}
