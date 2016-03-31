<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MAP
 *
 * @ORM\Table(name="m_a_p")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\MAPRepository")
 */
class MAP
{

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Personne", cascade={"persist"})
     */
    private $laPersone;

    /**
     * @ORM\OneToMany(targetEntity="SiteBundle\Entity\Entreprise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Entreprise;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="aEteMaitreApprentissage", type="boolean")
     */
    private $aEteMaitreApprentissage;

    /**
     * @var bool
     *
     * @ORM\Column(name="aEteFormationMaitreApprentissage", type="boolean")
     */
    private $aEteFormationMaitreApprentissage;

    /**
     * @var string
     *
     * @ORM\Column(name="Fonction", type="string", length=255)
     */
    private $fonction;


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
     * Set aEteMaitreApprentissage
     *
     * @param boolean $aEteMaitreApprentissage
     * @return MAP
     */
    public function setAEteMaitreApprentissage($aEteMaitreApprentissage)
    {
        $this->aEteMaitreApprentissage = $aEteMaitreApprentissage;

        return $this;
    }

    /**
     * Get aEteMaitreApprentissage
     *
     * @return boolean 
     */
    public function getAEteMaitreApprentissage()
    {
        return $this->aEteMaitreApprentissage;
    }

    /**
     * Set aEteFormationMaitreApprentissage
     *
     * @param boolean $aEteFormationMaitreApprentissage
     * @return MAP
     */
    public function setAEteFormationMaitreApprentissage($aEteFormationMaitreApprentissage)
    {
        $this->aEteFormationMaitreApprentissage = $aEteFormationMaitreApprentissage;

        return $this;
    }

    /**
     * Get aEteFormationMaitreApprentissage
     *
     * @return boolean 
     */
    public function getAEteFormationMaitreApprentissage()
    {
        return $this->aEteFormationMaitreApprentissage;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     * @return MAP
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string 
     */
    public function getFonction()
    {
        return $this->fonction;
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
     * Get Entreprise
     *
     * @return Entreprise
     */
    public function getEntreprise()
    {
        return $this->Entreprise;
    }

    /**
     * Set Entreprise
     *
     * @param Entreprise $Entreprise
     * @return Etudiant
     */
    public function setEntreprise(Entreprise $Entreprise)
    {
        $this->Entreprise = $Entreprise;
    }
}
