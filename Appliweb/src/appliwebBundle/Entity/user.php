<?php

namespace appliwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * user
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="appliwebBundle\Repository\userRepository")
 */
class user
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_user", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Pseudo", type="string", length=16, unique=true)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=16)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="IsAdmin", type="boolean")
     */
    private $isAdmin;

    /**
     * @var int
     *
     * @ORM\Column(name="IsBan", type="boolean")
     */
    private $isBan;


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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return user
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return user
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return user
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isAdmin
     *
     * @param integer $isAdmin
     *
     * @return user
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return int
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set isBan
     *
     * @param boolean $isBan
     *
     * @return user
     */
    public function setIsBan($isBan)
    {
        $this->isBan = $isBan;

        return $this;
    }

    /**
     * Get isBan
     *
     * @return boolean
     */
    public function getIsBan()
    {
        return $this->isBan;
    }
}
