<?php
/**
 * Created by PhpStorm.
 * User: Yun
 * Date: 23/03/2017
 * Time: 12:17
 */

namespace GearPlusBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GearPlusBundle\Entity\Category;



class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $c = 0;

        while($c !=3)
        {
            $cat = new Category();
            if($c == 0)
            {
                $cat->setTitle("Tete");
                $cat->setDescription("Tout les produits de tête");
            }
            elseif($c == 1)
            {
                $cat->setTitle("Buste");
                $cat->setDescription("Tout les produits de Buste");
            }
            else
            {
                $cat->setTitle("Jambe");
                $cat->setDescription("Tout les produits de Jambe");
            }
            $manager->persist($cat);
            $c++;
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