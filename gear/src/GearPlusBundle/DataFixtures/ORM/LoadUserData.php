<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 23/03/2017
 * Time: 14:48
 */

namespace GearPlusBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GearPlusBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function  load(ObjectManager $manager){


        $i = 1;

        while($i <= 30){
            $prod = new User();
            $prod->setUsername("user".$i);
            $prod->setUsernameCanonical("Description du produit ".$i);
            $prod->setEmail("user".$i."@user.com");
            $prod->setEmailCanonical("user".$i."@user.com");
            $prod->setEnabled( 1);
            $prod->setLastLogin(new \DateTime());
            $prod->setPassword('123456');
            $prod->setRoles([]);
            $manager->persist($prod);
            $i++;
        }
        $manager->flush();

    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return 1;
    }

}