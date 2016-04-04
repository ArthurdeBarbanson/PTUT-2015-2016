<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\EtudiantRepository")
 */
class Etudiant
{


    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\DossierInscription", cascade={"persist"})
     */
    private $DossierInscription;
    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Personne", cascade={"persist"})
     */
    private $laPersone;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="CV", type="string", length=255)
     */
    private $cV;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeLicence", type="string", length=255)
     */
    private $typeLicence;

    /**
     * @var string
     *
     * @ORM\Column(name="VilleNaissance", type="string", length=255)
     */
    private $villeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="Nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="NumeroDossierCandidature", type="string", length=255)
     */
    private $numeroDossierCandidature;

    /**
     * @var string
     *
     * @ORM\Column(name="Statut", type="string", length=255)
     */
    private $statut;


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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Etudiant
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set cV
     *
     * @param string $cV
     * @return Etudiant
     */
    public function setCV($cV)
    {
        $this->cV = $cV;

        return $this;
    }

    /**
     * Get cV
     *
     * @return string 
     */
    public function getCV()
    {
        return $this->cV;
    }

    /**
     * Set typeLicence
     *
     * @param string $typeLicence
     * @return Etudiant
     */
    public function setTypeLicence($typeLicence)
    {
        $this->typeLicence = $typeLicence;

        return $this;
    }

    /**
     * Get typeLicence
     *
     * @return string 
     */
    public function getTypeLicence()
    {
        return $this->typeLicence;
    }

    /**
     * Set villeNaissance
     *
     * @param string $villeNaissance
     * @return Etudiant
     */
    public function setVilleNaissance($villeNaissance)
    {
        $this->villeNaissance = $villeNaissance;

        return $this;
    }

    /**
     * Get villeNaissance
     *
     * @return string 
     */
    public function getVilleNaissance()
    {
        return $this->villeNaissance;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     * @return Etudiant
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set numeroDossierCandidature
     *
     * @param string $numeroDossierCandidature
     * @return Etudiant
     */
    public function setNumeroDossierCandidature($numeroDossierCandidature)
    {
        $this->numeroDossierCandidature = $numeroDossierCandidature;

        return $this;
    }

    /**
     * Get numeroDossierCandidature
     *
     * @return string 
     */
    public function getNumeroDossierCandidature()
    {
        return $this->numeroDossierCandidature;
    }

    /**
     * Set statut
     *
     * @param string $statut
     * @return Etudiant
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Get laPersone
     *
     * @return Personne
     */
    public function getLaPersone()
    {
        return $this->laPersone;
    }

    /**
     * Set laPersone
     *
     * @param Personne $laPersone
     * @return Etudiant
     */
    public function setLaPersone(Personne $laPersone)
    {
        $this->laPersone = $laPersone;
    }

    /**
     * Get DossierInscription
     *
     * @return DossierInscription
     */
    public function getInscription()
    {
        return $this->DossierInscriptionInscription;
    }

    /**
     * Set DossierInscription
     *
     * @param DossierInscription $DossierInscription
     * @return Etudiant
     */
    public function setInscription($DossierInscription)
    {
        $this->DossierInscription = $DossierInscription;
    }

    public function getAge()
    {
        $dateInterval = $this->dateNaissance->diff(new \DateTime());

        return $dateInterval->y;
    }
}
