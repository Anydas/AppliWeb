<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cat_goodies
 *
 * @ORM\Table(name="cat_goodies")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\Cat_goodiesRepository")
 */
class Cat_goodies
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
    private $idcat;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_goodies", type="integer")
     */
    private $idGoodies;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idcat
     *
     * @param integer $idcat
     *
     * @return Cat_goodies
     */
    public function setIdcat($idcat)
    {
        $this->idcat = $idcat;

        return $this;
    }

    /**
     * Get idcat
     *
     * @return integer
     */
    public function getIdcat()
    {
        return $this->idcat;
    }

    /**
     * Set idGoodies
     *
     * @param integer $idGoodies
     *
     * @return Cat_goodies
     */
    public function setIdGoodies($idGoodies)
    {
        $this->idGoodies = $idGoodies;

        return $this;
    }

    /**
     * Get idGoodies
     *
     * @return integer
     */
    public function getIdGoodies()
    {
        return $this->idGoodies;
    }
}
