<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BacOuEquivalent
 *
 * @ORM\Table(name="bac_ou_equivalent")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\BacOuEquivalentRepository")
 */
class BacOuEquivalent
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
     * @ORM\Column(name="Intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="Mention", type="string", length=255)
     */
    private $mention;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeEtablissementObtention", type="string", length=255)
     */
    private $typeEtablissementObtention;

    /**
     * @var string
     *
     * @ORM\Column(name="DepartementEtablissementObtention", type="string", length=255)
     */
    private $departementEtablissementObtention;

    /**
     * @var string
     *
     * @ORM\Column(name="NomEtablissementObtention", type="string", length=255)
     */
    private $nomEtablissementObtention;


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
     * Set intitule
     *
     * @param string $intitule
     * @return BacOuEquivalent
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set mention
     *
     * @param string $mention
     * @return BacOuEquivalent
     */
    public function setMention($mention)
    {
        $this->mention = $mention;

        return $this;
    }

    /**
     * Get mention
     *
     * @return string 
     */
    public function getMention()
    {
        return $this->mention;
    }

    /**
     * Set typeEtablissementObtention
     *
     * @param string $typeEtablissementObtention
     * @return BacOuEquivalent
     */
    public function setTypeEtablissementObtention($typeEtablissementObtention)
    {
        $this->typeEtablissementObtention = $typeEtablissementObtention;

        return $this;
    }

    /**
     * Get typeEtablissementObtention
     *
     * @return string 
     */
    public function getTypeEtablissementObtention()
    {
        return $this->typeEtablissementObtention;
    }

    /**
     * Set departementEtablissementObtention
     *
     * @param string $departementEtablissementObtention
     * @return BacOuEquivalent
     */
    public function setDepartementEtablissementObtention($departementEtablissementObtention)
    {
        $this->departementEtablissementObtention = $departementEtablissementObtention;

        return $this;
    }

    /**
     * Get departementEtablissementObtention
     *
     * @return string 
     */
    public function getDepartementEtablissementObtention()
    {
        return $this->departementEtablissementObtention;
    }

    /**
     * Set nomEtablissementObtention
     *
     * @param string $nomEtablissementObtention
     * @return BacOuEquivalent
     */
    public function setNomEtablissementObtention($nomEtablissementObtention)
    {
        $this->nomEtablissementObtention = $nomEtablissementObtention;

        return $this;
    }

    /**
     * Get nomEtablissementObtention
     *
     * @return string 
     */
    public function getNomEtablissementObtention()
    {
        return $this->nomEtablissementObtention;
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
