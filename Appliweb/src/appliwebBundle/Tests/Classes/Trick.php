<?php

//namespace appliwebBundle\Entity;

//use Doctrine\ORM\Mapping as ORM;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_trick", type="integer")
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
     * @ORM\Column(name="Id_user", type="integer")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="Trick_description", type="string", length=5000)
     */
    private $trickDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_like", type="integer")
     */
    private $nbLike;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_dislike", type="integer")
     */
    private $nbDislike;

    /**
     * @var int
     *
     * @ORM\Column(name="IsPublish", type="boolean")
     */
    private $isPublish;


    public function __construct()
     {
       // Par défaut, la date de l'annonce est la date d'aujourd'hui
       $this->date = new \Datetime();
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
     * Set idCat
     *
     * @param integer $idCat
     *
     * @return Trick
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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Trick
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set trickDescription
     *
     * @param string $trickDescription
     *
     * @return Trick
     */
    public function setTrickDescription($trickDescription)
    {
        $this->trickDescription = $trickDescription;

        return $this;
    }

    /**
     * Get trickDescription
     *
     * @return string
     */
    public function getTrickDescription()
    {
        return $this->trickDescription;
    }

    /**
     * Set nbLike
     *
     * @param integer $nbLike
     *
     * @return Trick
     */
    public function setNbLike($nbLike)
    {
        $this->nbLike = $nbLike;

        return $this;
    }

    /**
     * Get nbLike
     *
     * @return int
     */
    public function getNbLike()
    {
        return $this->nbLike;
    }

    /**
     * Set nbDislike
     *
     * @param integer $nbDislike
     *
     * @return Trick
     */
    public function setNbDislike($nbDislike)
    {
        $this->nbDislike = $nbDislike;

        return $this;
    }

    /**
     * Get nbDislike
     *
     * @return int
     */
    public function getNbDislike()
    {
        return $this->nbDislike;
    }

    /**
     * Set isPublish
     *
     * @param integer $isPublish
     *
     * @return Trick
     */
    public function setIsPublish($isPublish)
    {
        $this->isPublish = $isPublish;

        return $this;
    }

    /**
     * Get isPublish
     *
     * @return int
     */
    public function getIsPublish()
    {
        return $this->isPublish;
    }
}
