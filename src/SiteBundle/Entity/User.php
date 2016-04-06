<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Entreprise", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_entreprise;

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Etudiant", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $id_etudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

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

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
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
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
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
     * Set idEntreprise
     *
     * @param integer $idEntreprise
     *
     * @return User
     */
    public function setIdEntreprise($idEntreprise)
    {
        $this->id_entreprise = $idEntreprise;

        return $this;
    }

    /**
     * Get idEntreprise
     *
     * @return integer
     */
    public function getIdEntreprise()
    {
        return $this->id_entreprise;
    }

    /**
     * Set idEtudiant
     *
     * @param \SiteBundle\Entity\Etudiant $idEtudiant
     *
     * @return User
     */
    public function setIdEtudiant(\SiteBundle\Entity\Etudiant $idEtudiant = null)
    {
        $this->id_etudiant = $idEtudiant;

        return $this;
    }

    /**
     * Get idEtudiant
     *
     * @return \SiteBundle\Entity\Etudiant
     */
    public function getIdEtudiant()
    {
        return $this->id_etudiant;
    }
}
