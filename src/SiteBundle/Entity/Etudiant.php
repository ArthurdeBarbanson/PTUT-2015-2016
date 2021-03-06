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
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Session", cascade={"persist"})
     */
    private $Session;

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\DossierInscription", cascade={"persist"})
     */
    private $DossierInscription;
    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Personne", cascade={"persist"})
     */
    private $laPersone;
    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Personne", cascade={"persist"})
     */
    private $leTuteur;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateNaissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="CV", type="string", length=255, nullable=true)
     */
    private $cV;

    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="enum('METINET', 'IEM')",nullable=true)
     */
    private $typeLicence;
    /**
     * @var string
     *
     * @ORM\Column(name="VilleNaissance", type="string", length=255, nullable=true)
     */
    private $villeNaissance;
    /**
     * @var string
     *
     * @ORM\Column(name="Nationalite", type="string", length=255, nullable=true)
     */
    private $nationalite;
    /**
     * @var string
     *
     * @ORM\Column(name="NumeroDossierCandidature", type="string", length=255, nullable=true)
     */
    private $numeroDossierCandidature;

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\DossierAdmission", cascade={"persist"})
     */
    private $dossierAdmission;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @var boolean $isAdmissible
     *
     * @ORM\Column(name="isAdmissible", type="boolean")
     */
    private $isAdmissible = false;


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
     * @param boolean $statut
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
     * @return boolean
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
        return $this->DossierInscription;
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

    /**
     * Get leTuteur
     *
     * @return Personne
     */
    public function getleTuteur()
    {
        return $this->leTuteur;
    }

    /**
     * Set leTuteur
     *
     * @param Personne $leTuteur
     * @return Personne
     */
    public function setleTuteur(Personne $leTuteur)
    {
        $this->leTuteur = $leTuteur;
    }

    /**
     * Set dossierInscription
     *
     * @param \SiteBundle\Entity\DossierInscription $dossierInscription
     *
     * @return Etudiant
     */
    public function setDossierInscription(\SiteBundle\Entity\DossierInscription $dossierInscription = null)
    {
        $this->DossierInscription = $dossierInscription;

        return $this;
    }

    /**
     * Get dossierInscription
     *
     * @return \SiteBundle\Entity\DossierInscription
     */
    public function getDossierInscription()
    {
        return $this->DossierInscription;
    }

    /**
     * Set session
     *
     * @param \SiteBundle\Entity\Session $session
     *
     * @return Etudiant
     */
    public function setSession(\SiteBundle\Entity\Session $session = null)
    {
        $this->Session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \SiteBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->Session;
    }

    /**
     * Set isAdmissible
     *
     * @param boolean $isAdmissible
     *
     * @return Etudiant
     */
    public function setIsAdmissible($isAdmissible)
    {
        $this->isAdmissible = $isAdmissible;

        return $this;
    }

    /**
     * Get isAdmissible
     *
     * @return boolean
     */
    public function getIsAdmissible()
    {
        return $this->isAdmissible;
    }

    /**
     * Set dossierAdmission
     *
     * @param \SiteBundle\Entity\DossierAdmission $dossierAdmission
     *
     * @return Etudiant
     */
    public function setDossierAdmission(\SiteBundle\Entity\DossierAdmission $dossierAdmission = null)
    {
        $this->dossierAdmission = $dossierAdmission;

        return $this;
    }

    /**
     * Get dossierAdmission
     *
     * @return \SiteBundle\Entity\DossierAdmission
     */
    public function getDossierAdmission()
    {
        return $this->dossierAdmission;
    }
}
