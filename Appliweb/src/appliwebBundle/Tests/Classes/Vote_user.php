<?php

//namespace appliwebBundle\Entity;

//use Doctrine\ORM\Mapping as ORM;

/**
 * Vote_user
 *
 * @ORM\Table(name="vote_user")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\Vote_userRepository")
 */
class Vote_user
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
     * @ORM\Column(name="Id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_trick", type="integer")
     */
    private $idTrick;


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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Vote_user
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
     * Set idTrick
     *
     * @param integer $idTrick
     *
     * @return Vote_user
     */
    public function setIdTrick($idTrick)
    {
        $this->idTrick = $idTrick;

        return $this;
    }

    /**
     * Get idTrick
     *
     * @return int
     */
    public function getIdTrick()
    {
        return $this->idTrick;
    }
}
