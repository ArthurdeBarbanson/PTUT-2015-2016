<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SiteBundle\Entity\Session;

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
     * @ORM\Column(name="etat_offre", type="string", columnDefinition="enum('En attente de validation','En ligne','Pourvue','En attente de modification','Refuser')" ,nullable=true , options={"default":"0"})
     */
    private $etatOffre;


    /**
     * @var string
     *
     * @ORM\Column(name="licence_concerne",type="string", columnDefinition="enum('METINET', 'IEM')",nullable=true)
     */
    private $licenceConcerne;

    /**
     * @var string
     *
     * @ORM\Column(name="Sujet", type="text",nullable=true)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Entreprise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Entreprise;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\MAP")
     * @ORM\JoinColumn(nullable=false)
     */
    private $MAP;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Etudiant")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Etudiant;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Session", cascade={"persist"})
     */
    private $Session;

    /**
     * @var string
     *
     * @ORM\Column(name="type_contrat",type="string", columnDefinition="enum('Apprentissage', 'Professionnalisation')",nullable=true)
     */
    private $typeContrat;


    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", length=255,nullable=true)
     */
    private $document;






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
     * @return Offre
     */
    public function setEntreprise ($Entreprise)
    {
        $this->Entreprise = $Entreprise;
    }

    /**
     * Get MAP
     *
     * @return MAP
     */
    public function getMAP()
    {
        return $this->MAP;
    }

    /**
     * Set MAP
     *
     * @param MAP $MAP
     * @return Offre
     */
    public function setMAP($MAP)
    {
        $this->MAP = $MAP;
    }

    /**
     * Get Etudiant
     *
     * @return Etudiant
     */
    public function getEtudiant()
    {
        return $this->Etudiant;
    }

    /**
     * Set Etudiant
     *
     * @param Etudiant $Etudiant
     * @return Offre
     */
    public function setEtudiant($Etudiant)
    {
        $this->Etudiant = $Etudiant;
    }





    /**
     * Set session
     *
     * @param \SiteBundle\Entity\Session $session
     *
     * @return Offre
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
     * Set typeContrat
     *
     * @param string $typeContrat
     *
     * @return Offre
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    /**
     * Get typeContrat
     *
     * @return string
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    /**
     * Set document
     *
     * @param string $document
     *
     * @return Offre
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }
}
