<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Cat
 *
 * @ORM\Table(name="cat")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\CatRepository")
 */
class Cat
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_cat", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="French_name", type="string", length=15)
     */
    private $frenchName;

    /**
     * @var string
     *
     * @ORM\Column(name="Japanese_name", type="string", length=45)
     */
    private $japaneseName;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=45)
     */

    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Personality", type="string", length=20)
     */
    private $personality;

    /**
     * @var int
     *
     * @ORM\Column(name="Level", type="integer")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="IsRare", type="boolean")
     */
    private $isRare;

    /**
     * @var int
     *
     * @ORM\Column(name="IsPublish", type="boolean")
     */
    private $isPublish;


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
     * Set frenchName
     *
     * @param string $frenchName
     *
     * @return Cat
     */
    public function setFrenchName($frenchName)
    {
        $this->frenchName = $frenchName;

        return $this;
    }

    /**
     * Get frenchName
     *
     * @return string
     */
    public function getFrenchName()
    {
        return $this->frenchName;
    }

    /**
     * Set japaneseName
     *
     * @param string $japaneseName
     *
     * @return Cat
     */
    public function setJapaneseName($japaneseName)
    {
        $this->japaneseName = $japaneseName;

        return $this;
    }

    /**
     * Get japaneseName
     *
     * @return string
     */
    public function getJapaneseName()
    {
        return $this->japaneseName;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Cat
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
     * Set personality
     *
     * @param string $personality
     *
     * @return Cat
     */
    public function setPersonality($personality)
    {
        $this->personality = $personality;

        return $this;
    }

    /**
     * Get personality
     *
     * @return string
     */
    public function getPersonality()
    {
        return $this->personality;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Cat
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set isRare
     *
     * @param boolean $isRare
     *
     * @return Cat
     */
    public function setIsRare($isRare)
    {
        $this->isRare = $isRare;

        return $this;
    }

    /**
     * Get isRare
     *
     * @return boolean
     */
    public function getIsRare()
    {
        return $this->isRare;
    }



    /**
     * Set isPublish
     *
     * @param boolean $isPublish
     *
     * @return Cat
     */
    public function setIsPublish($isPublish)
    {
        $this->isPublish = $isPublish;

        return $this;
    }

    /**
     * Get isPublish
     *
     * @return boolean
     */
    public function getIsPublish()
    {
        return $this->isPublish;
    }
}
