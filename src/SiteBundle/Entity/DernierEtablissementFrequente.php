<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DernierEtablissementFrequente
 *
 * @ORM\Table(name="dernier_etablissement_frequente")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DernierEtablissementFrequenteRepository")
 */
class DernierEtablissementFrequente
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
     * @var bool
     *
     * @ORM\Column(name="estLyon1", type="boolean")
     */
    private $estLyon1;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Departement", type="string", length=255)
     */
    private $departement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Annee", type="date")
     */
    private $annee;

    /**
     * @var bool
     *
     * @ORM\Column(name="estTransfert", type="boolean")
     */
    private $estTransfert;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255)
     */
    private $type;


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
     * Set estLyon1
     *
     * @param boolean $estLyon1
     * @return DernierEtablissementFrequente
     */
    public function setEstLyon1($estLyon1)
    {
        $this->estLyon1 = $estLyon1;

        return $this;
    }

    /**
     * Get estLyon1
     *
     * @return boolean 
     */
    public function getEstLyon1()
    {
        return $this->estLyon1;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return DernierEtablissementFrequente
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
     * Set departement
     *
     * @param string $departement
     * @return DernierEtablissementFrequente
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
     * @param \DateTime $annee
     * @return DernierEtablissementFrequente
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \DateTime 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set estTransfert
     *
     * @param boolean $estTransfert
     * @return DernierEtablissementFrequente
     */
    public function setEstTransfert($estTransfert)
    {
        $this->estTransfert = $estTransfert;

        return $this;
    }

    /**
     * Get estTransfert
     *
     * @return boolean 
     */
    public function getEstTransfert()
    {
        return $this->estTransfert;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return DernierEtablissementFrequente
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
