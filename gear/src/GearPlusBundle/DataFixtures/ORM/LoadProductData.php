<?php
/**
 * Created by PhpStorm.
 * User: Yun
 * Date: 23/03/2017
 * Time: 11:07
 */

namespace GearPlusBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GearPlusBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i = 1;

        while($i <= 30){
            $prod = new Product();
            $cat = $manager->getRepository("GearPlusBundle:Category")->find(rand(1,3));
            $prod->setTitle("Produit ".$i);
            $prod->setDescription("Description du produit ".$i);
            $prod->setPrix(rand (1, 200));
            $prod->setBeaute(rand ( 1 , 15));
            $prod->setCharisme(rand ( 1 , 15));
            $prod->setIntelligence(rand ( 1 , 15));
            $prod->setCategory($cat);
            $manager->persist($prod);
            $i++;
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return 2;
    }
}