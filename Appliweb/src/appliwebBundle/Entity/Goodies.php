<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goodies
 *
 * @ORM\Table(name="goodies")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\GoodiesRepository")
 */
class Goodies
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_goodies", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=45, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=250)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Size", type="string", length=1)
     */
    private $size;

    /**
     * @var int
     *
     * @ORM\Column(name="Fit", type="smallint")
     */
    private $fit;

    /**
     * @var int
     *
     * @ORM\Column(name="Price", type="smallint")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="IsGold", type="boolean")
     */
    private $isGold;

    /**
     * @var string
     *
     * @ORM\Column(name="Category", type="string", length=45)
     */
    private $category;



    public function __construct()
     {

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
     * Set name
     *
     * @param string $name
     *
     * @return Goodies
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Goodies
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
     * Set size
     *
     * @param string $size
     *
     * @return Goodies
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set fit
     *
     * @param integer $fit
     *
     * @return Goodies
     */
    public function setFit($fit)
    {
        $this->fit = $fit;

        return $this;
    }

    /**
     * Get fit
     *
     * @return int
     */
    public function getFit()
    {
        return $this->fit;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Goodies
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isGold
     *
     * @param boolean $isGold
     *
     * @return Goodies
     */
    public function setIsGold($isGold)
    {
        $this->isGold = $isGold;

        return $this;
    }

    /**
     * Get isGold
     *
     * @return boolean
     */
    public function getIsGold()
    {
        return $this->isGold;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Goodies
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}
