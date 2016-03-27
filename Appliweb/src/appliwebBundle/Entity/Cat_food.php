<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cat_food
 *
 * @ORM\Table(name="cat_food")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\Cat_foodRepository")
 */
class Cat_food
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_rela", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_cat", type="integer")
     */
    private $idCat;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_food", type="integer")
     */
    private $idFood;


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
     * Set idCat
     *
     * @param integer $idCat
     *
     * @return Cat_food
     */
    public function setIdCat($idCat)
    {
        $this->idCat = $idCat;

        return $this;
    }

    /**
     * Get idCat
     *
     * @return int
     */
    public function getIdCat()
    {
        return $this->idCat;
    }

    /**
     * Set idFood
     *
     * @param integer $idFood
     *
     * @return Cat_food
     */
    public function setIdFood($idFood)
    {
        $this->idFood = $idFood;

        return $this;
    }

    /**
     * Get idFood
     *
     * @return int
     */
    public function getIdFood()
    {
        return $this->idFood;
    }
}
