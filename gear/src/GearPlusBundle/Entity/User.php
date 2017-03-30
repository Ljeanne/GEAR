<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 16/03/2017
 * Time: 11:37
 */
namespace GearPlusBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="user" , cascade={"persist"})

     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $products;




    /**
     * @var string
     * @ORM\Column (name="avatar", type="string", length=255)
     */

    private $avatar="https://cdn1.iconfinder.com/data/icons/ninja-things-1/1772/ninja-128.png";

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
