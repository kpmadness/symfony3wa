<?php

namespace Troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Troiswa\BackBundle\Entity\Coupon;


class LoadCouponData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {


        $user = new Coupon();
        $user->setCode('X457KM');
        $user->setDetail('Une réduction rafrachaissante pour l\'été');
        $user->setReduction('60');
        $user->setType('Summer folies');
        $user->setDateExpire(new \DateTime('2015-11-17'));

        $manager->persist($user);
        $manager->flush();

        $user = new Coupon();
        $user->setCode('T4GGU3');
        $user->setDetail('Une réduction rafrachaissante pour l\'été');
        $user->setReduction('40');
        $user->setType('Summer folies');
        $user->setDateExpire(new \DateTime('2015-11-17'));

        $manager->persist($user);
        $manager->flush();


        $user = new Coupon();
        $user->setCode('PO59BQ');
        $user->setDetail('Une réduction rafrachaissante pour l\'été');
        $user->setReduction('30');
        $user->setType('Summer folies');
        $user->setDateExpire(new \DateTime('2015-11-17'));

        $manager->persist($user);
        $manager->flush();

    }

    public function getOrder()
    {
//        return 1;
    }

}
