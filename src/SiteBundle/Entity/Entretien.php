<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DossierInscription
 *
 * @ORM\Table(name="entretien_etudiant")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DossierEntretienRepository")
 */
class Entretien
{
    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", columnDefinition="enum('0','1','2','3','4')" ,nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

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
     * @ORM\Column(name="DatePassage", type="date", nullable=true)
     */
    private $datePassage;

    /**
     * Set etatDossier
     *
     * @param string $etatDossier
     *
     * @return Entretien
     */
    public function setEtatDossier($etatDossier)
    {
        $this->etatDossier = $etatDossier;

        return $this;
    }

    /**
     * Get etatDossier
     *
     * @return string
     */
    public function getEtatDossier()
    {
        return $this->etatDossier;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Entretien
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

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
     * Set datePassage
     *
     * @param \DateTime $datePassage
     *
     * @return Entretien
     */
    public function setDatePassage($datePassage)
    {
        $this->datePassage = $datePassage;

        return $this;
    }

    /**
     * Get datePassage
     *
     * @return \DateTime
     */
    public function getDatePassage()
    {
        return $this->datePassage;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Entretien
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }
}
