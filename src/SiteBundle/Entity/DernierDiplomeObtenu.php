<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DernierDiplomeObtenu
 *
 * @ORM\Table(name="dernier_diplome_obtenu")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DernierDiplomeObtenuRepository")
 */
class DernierDiplomeObtenu
{
    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\DossierInscription")
     * @ORM\JoinColumn(nullable=false)
     */
    private $DossierInscription;

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
     * @ORM\Column(name="Departement", type="string", length=255)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="Annee", type="string", length=255)
     */
    private $annee;

    /**
     * @var string
     *
     * @ORM\Column(name="Etablissement", type="string", length=255)
     */
    private $etablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="LeDiplomeObtenue", type="string", length=255)
     */
    private $leDiplomeObtenue;


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
     * Set departement
     *
     * @param string $departement
     * @return DernierDiplomeObtenu
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set annee
     *
     * @param string $annee
     * @return DernierDiplomeObtenu
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set etablissement
     *
     * @param string $etablissement
     * @return DernierDiplomeObtenu
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return string 
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Set leDiplomeObtenue
     *
     * @param string $leDiplomeObtenue
     * @return DernierDiplomeObtenu
     */
    public function setLeDiplomeObtenue($leDiplomeObtenue)
    {
        $this->leDiplomeObtenue = $leDiplomeObtenue;

        return $this;
    }

    /**
     * Get leDiplomeObtenue
     *
     * @return string 
     */
    public function getLeDiplomeObtenue()
    {
        return $this->leDiplomeObtenue;
    }
    /**
     * Get DossierInscription
     *
     * @return DossierInscription
     */
    public function getDossierInscription()
    {
        return $this->DossierInscription;
    }

    /**
     * Set DossierInscription
     *
     * @param DossierInscription $DossierInscription
     * @return DossierInscription
     */
    public function setDossierInscription($DossierInscription)
    {
        $this->DossierInscription = $DossierInscription;
    }

}
