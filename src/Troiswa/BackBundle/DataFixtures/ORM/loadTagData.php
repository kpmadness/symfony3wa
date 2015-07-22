<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Troiswa\BackBundle\Entity\Tag;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{


    public function load(ObjectManager $manager)
    {

//        $tagTab= array('Ecran','TV','Meuble','Son','Image','Telephonie','Marque');
//
//        foreach($tagTab as $valTag){
//
//            $tag = new Tag();
//            $tag->setTag($valTag);
//            $manager->persist($tag);
//            $manager->flush();
//
//        }

    }

    public function getOrder()
    {
//        return 1;
    }

}
