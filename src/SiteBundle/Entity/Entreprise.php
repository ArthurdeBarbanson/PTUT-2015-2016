<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\EntrepriseRepository")
 */
class Entreprise
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
     * @ORM\Column(name="Mail", type="string", length=50)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="RaisonSocial", type="string", length=50)
     */
    private $raisonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="NombrePersonne", type="string", length=50)
     */
    private $nombrePersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="Siret", type="string", length=50)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="APE", type="string", length=50)
     */
    private $aPE;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="SiteWeb", type="string", length=50, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=50)
     */
    private $telephone;

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Adresse", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $Adresse;


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
     * @return Entreprise
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
     * @return Entreprise
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
     * Set mail
     *
     * @param string $mail
     * @return Entreprise
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
     * Set raisonSocial
     *
     * @param string $raisonSocial
     * @return Entreprise
     */
    public function setRaisonSocial($raisonSocial)
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
    }

    /**
     * Get raisonSocial
     *
     * @return string 
     */
    public function getRaisonSocial()
    {
        return $this->raisonSocial;
    }

    /**
     * Set nombrePersonne
     *
     * @param string $nombrePersonne
     * @return Entreprise
     */
    public function setNombrePersonne($nombrePersonne)
    {
        $this->nombrePersonne = $nombrePersonne;

        return $this;
    }

    /**
     * Get nombrePersonne
     *
     * @return string 
     */
    public function getNombrePersonne()
    {
        return $this->nombrePersonne;
    }

    /**
     * Set siret
     *
     * @param string $siret
     * @return Entreprise
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set aPE
     *
     * @param string $aPE
     * @return Entreprise
     */
    public function setAPE($aPE)
    {
        $this->aPE = $aPE;

        return $this;
    }

    /**
     * Get aPE
     *
     * @return string 
     */
    public function getAPE()
    {
        return $this->aPE;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Entreprise
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
     * Set siteWeb
     *
     * @param string $siteWeb
     * @return Entreprise
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string 
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Entreprise
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
     * @return Entreprise
     */
    public function setAdresse($Adresse)
    {
        $this->Adresse = $Adresse;
    }
}
