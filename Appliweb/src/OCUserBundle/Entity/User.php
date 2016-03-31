<?php

namespace OCUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* User
*
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="OCUserBundle\Repository\UserRepository")
*/
class User implements UserInterface
{
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
  * @ORM\Column(name="username", type="string", length=20, unique=true)
  */
  private $username;

  /**
  * @var string
  *
  * @ORM\Column(name="password", type="string", length=18)
  */
  private $password;

  /**
  * @var array
  *
  * @ORM\Column(name="salt", type="string", length=255)
  */
  private $salt;

  /**
  * @var array
  *
  * @ORM\Column(name="role", type="array")
  */
  private $roles;

  /**
  * @var string
  *
  * @ORM\Column(name="email", type="string", length=70, unique=true)
  */
  private $email;

  /**
  * @var bool
  *
  * @ORM\Column(name="isban", type="boolean")
  */
  private $isban;


  public function eraseCredentials()
  {
  }



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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
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
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set isban
     *
     * @param boolean $isban
     *
     * @return User
     */
    public function setIsban($isban)
    {
        $this->isban = $isban;

        return $this;
    }

    /**
     * Get isban
     *
     * @return boolean
     */
    public function getIsban()
    {
        return $this->isban;
    }
}
