<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PieceJointe
 *
 * @ORM\Table(name="piece_jointe")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\PieceJointeRepository")
 */
class PieceJointe
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
     * @ORM\Column(name="Nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Chemin", type="string", length=255, unique=true)
     */
    private $chemin;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\EmailEtapeInscription")
     * @ORM\JoinColumn(name="email_etape_inscription_id", referencedColumnName="id")
     */
    private $EmailEtapeInscription;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return PieceJointe
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
     * Set chemin
     *
     * @param string $chemin
     *
     * @return PieceJointe
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set emailEtapeInscription
     *
     * @param \SiteBundle\Entity\EmailEtapeInscription $emailEtapeInscription
     *
     * @return PieceJointe
     */
    public function setEmailEtapeInscription(\SiteBundle\Entity\EmailEtapeInscription $emailEtapeInscription = null)
    {
        $this->EmailEtapeInscription = $emailEtapeInscription;

        return $this;
    }

    /**
     * Get emailEtapeInscription
     *
     * @return \SiteBundle\Entity\EmailEtapeInscription
     */
    public function getEmailEtapeInscription()
    {
        return $this->EmailEtapeInscription;
    }
}
