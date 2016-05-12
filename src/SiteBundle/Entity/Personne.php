<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\PersonneRepository")
 */
class Personne
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
     * @ORM\Column(name="Nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe", type="string", length=5,nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="Mail", type="string", length=50)
     */
    private $mail;



    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Adresse", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $Adresse;

    /**
     * @var bool
     *
     * @ORM\Column(name="isTuteur", type="boolean", )
     */
    private $isTuteur = false;


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
     * Set nom
     *
     * @param string $nom
     * @return Personne
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Personne
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Personne
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Personne
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }


    /**
     * Get Adresse
     *
     * @return Adresse
     */
    public function getAdresse()
    {
        return $this->Adresse;
    }

    /**
     * Set Adresse
     *
     * @param Adresse $Adresse
     * @return Personne
     */
    public function setAdresse($Adresse)
    {
        $this->Adresse = $Adresse;
    }

    /**
     * Set isTuteur
     *
     * @param boolean $isTuteur
     * @return Personne
     */
    public function setisTuteur($isTuteur)
    {
        $this->isTuteur = $isTuteur;

        return $this;
    }

    /**
     * Get isTuteur
     *
     * @return boolean
     */
    public function getisTuteur()
    {
        return $this->isTuteur;
    }
}
