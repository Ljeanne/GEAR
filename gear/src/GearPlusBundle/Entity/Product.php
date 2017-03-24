<?php

namespace GearPlusBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="GearPlusBundle\Repository\ProductRepository")
 */
class Product
{

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products" , cascade={"persist"})

     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer")
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="charisme", type="integer")
     */
    private $charisme;

    /**
     * @var int
     *
     * @ORM\Column(name="intelligence", type="integer")
     */
    private $intelligence;

    /**
     * @var integer
     *
     * @ORM\Column(name="beaute", type="integer")
     */
    private $beaute;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Product
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**

     * Set charisme
     *
     * @param integer $charisme
     *
     * @return Product
     */
    public function setCharisme($charisme)
    {
        $this->charisme = $charisme;

        return $this;
    }

    /**
     * Get charisme
     *
     * @return int
     */
    public function getCharisme()
    {
        return $this->charisme;
    }

    /**
     * Set intelligence
     *
     * @param integer $intelligence
     *
     * @return Product
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    /**
     * Get intelligence
     *
     * @return int
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * Set beaute
     *
     * @param \integer $beaute
     *
     * @return Product
     */
    public function setBeaute($beaute)
    {
        $this->beaute = $beaute;

        return $this;
    }

    /**
     * Get beaute
     *
     * @return \integer
     */
    public function getBeaute()
    {
        return $this->beaute;
    }

    /**
     * Set category
     *
     * @param \GearPlusBundle\Entity\Category $category
     *
     * @return Product
     */

    public function setCategory(\GearPlusBundle\Entity\Category $category = null)


    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \GearPlusBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString()
    {
            return (string) $this->getCategory();

    }
}
