<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Troiswa\BackBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setFirstname('John');
        $user->setLastname('Abbott');
        $user->setAddress('13 rue des Coquelicots');
        $user->getBirthdate('1952-07-25');
        $user->getMail('j.abbott@restless.com');
        $user->getPassword('abbott99');



        $manager->persist($user);
        $manager->flush();


        $this->addReference('userRef', $user);
    }

//    public function getOrder()
//    {
//        return 1;
//    }

}
