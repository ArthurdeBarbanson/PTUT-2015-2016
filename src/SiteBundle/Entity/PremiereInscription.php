<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PremiereInscription
 *
 * @ORM\Table(name="premiere_inscription")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\PremiereInscriptionRepository")
 */
class PremiereInscription
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
     * @ORM\Column(name="AnneeInscriptionLyon1", type="date")
     */
    private $anneeInscriptionLyon1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="AnneeUniversiteFrancaise", type="date")
     */
    private $anneeUniversiteFrancaise;

    /**
     * @var string
     *
     * @ORM\Column(name="NomUniversite", type="string", length=255)
     */
    private $nomUniversite;

    /**
     * @var string
     *
     * @ORM\Column(name="AnneeEnseignementSuperieur", type="string", length=255)
     */
    private $anneeEnseignementSuperieur;


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
     * Set anneeInscriptionLyon1
     *
     * @param \DateTime $anneeInscriptionLyon1
     * @return PremiereInscription
     */
    public function setAnneeInscriptionLyon1($anneeInscriptionLyon1)
    {
        $this->anneeInscriptionLyon1 = $anneeInscriptionLyon1;

        return $this;
    }

    /**
     * Get anneeInscriptionLyon1
     *
     * @return \DateTime 
     */
    public function getAnneeInscriptionLyon1()
    {
        return $this->anneeInscriptionLyon1;
    }

    /**
     * Set anneeUniversiteFrancaise
     *
     * @param \DateTime $anneeUniversiteFrancaise
     * @return PremiereInscription
     */
    public function setAnneeUniversiteFrancaise($anneeUniversiteFrancaise)
    {
        $this->anneeUniversiteFrancaise = $anneeUniversiteFrancaise;

        return $this;
    }

    /**
     * Get anneeUniversiteFrancaise
     *
     * @return \DateTime 
     */
    public function getAnneeUniversiteFrancaise()
    {
        return $this->anneeUniversiteFrancaise;
    }

    /**
     * Set nomUniversite
     *
     * @param string $nomUniversite
     * @return PremiereInscription
     */
    public function setNomUniversite($nomUniversite)
    {
        $this->nomUniversite = $nomUniversite;

        return $this;
    }

    /**
     * Get nomUniversite
     *
     * @return string 
     */
    public function getNomUniversite()
    {
        return $this->nomUniversite;
    }

    /**
     * Set anneeEnseignementSuperieur
     *
     * @param string $anneeEnseignementSuperieur
     * @return PremiereInscription
     */
    public function setAnneeEnseignementSuperieur($anneeEnseignementSuperieur)
    {
        $this->anneeEnseignementSuperieur = $anneeEnseignementSuperieur;

        return $this;
    }

    /**
     * Get anneeEnseignementSuperieur
     *
     * @return string 
     */
    public function getAnneeEnseignementSuperieur()
    {
        return $this->anneeEnseignementSuperieur;
    }
}
