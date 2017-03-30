<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 30/03/2017
 * Time: 16:01
 */

namespace GearPlusBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="melon\RefappBundle\Entity\ApplicationRepository")
 */
class Favoris {

    // attributs //
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="products" , cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="product", inversedBy="products" , cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;


}