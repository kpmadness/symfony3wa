<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Troiswa\BackBundle\Entity\Brand;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadBrandData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

//        $brand = new Brand();
//        $brand->setTitle('LG');
//        $brand->setDescription('la puissance de la technologie');
//
//        $manager->persist($brand);
//        $manager->flush();
//
//
//        $this->addReference('refbd', $brand);
    }

    public function getOrder()
    {
//        return 1;
    }
}
