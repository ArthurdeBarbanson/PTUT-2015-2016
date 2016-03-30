<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\OffreRepository")
 */
class Offre
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateDepot", type="date")
     */
    private $dateDepot;

    /**
     * @var string
     *
     * @ORM\Column(name="EtatOffre", type="string", length=255)
     */
    private $etatOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="LicenceConcerne", type="string", length=255)
     */
    private $licenceConcerne;

    /**
     * @var string
     *
     * @ORM\Column(name="Sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255)
     */
    private $titre;


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
     * Set dateDepot
     *
     * @param \DateTime $dateDepot
     * @return Offre
     */
    public function setDateDepot($dateDepot)
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    /**
     * Get dateDepot
     *
     * @return \DateTime 
     */
    public function getDateDepot()
    {
        return $this->dateDepot;
    }

    /**
     * Set etatOffre
     *
     * @param string $etatOffre
     * @return Offre
     */
    public function setEtatOffre($etatOffre)
    {
        $this->etatOffre = $etatOffre;

        return $this;
    }

    /**
     * Get etatOffre
     *
     * @return string 
     */
    public function getEtatOffre()
    {
        return $this->etatOffre;
    }

    /**
     * Set licenceConcerne
     *
     * @param string $licenceConcerne
     * @return Offre
     */
    public function setLicenceConcerne($licenceConcerne)
    {
        $this->licenceConcerne = $licenceConcerne;

        return $this;
    }

    /**
     * Get licenceConcerne
     *
     * @return string 
     */
    public function getLicenceConcerne()
    {
        return $this->licenceConcerne;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return Offre
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Offre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }


}
