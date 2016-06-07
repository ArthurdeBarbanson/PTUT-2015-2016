<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DossierInscription
 *
 * @ORM\Table(name="dossier_admission")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DossierAdmissionRepository")
 */
class DossierAdmission
{
    /**
     * @var string
     *
     * @ORM\Column(name="etat_dossier", type="string", columnDefinition="enum('0','1','2','3','4')" ,nullable=true)
     */
    private $etatDossier;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Entretien", cascade={"persist"})
     */
    private $entretien;

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
     * @ORM\Column(name="DateLimite", type="date", nullable=true)
     */
    private $dateLimite;

    /**
     * Set etatDossier
     *
     * @param string $etatDossier
     *
     * @return DossierAdmission
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
     * @return DossierAdmission
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
     * Set dateLimite
     *
     * @param \DateTime $dateLimite
     *
     * @return DossierAdmission
     */
    public function setDateLimite($dateLimite)
    {
        $this->dateLimite = $dateLimite;

        return $this;
    }

    /**
     * Get dateLimite
     *
     * @return \DateTime
     */
    public function getDateLimite()
    {
        return $this->dateLimite;
    }

    /**
     * Set entretien
     *
     * @param \SiteBundle\Entity\Entretien $entretien
     *
     * @return DossierAdmission
     */
    public function setEntretien(\SiteBundle\Entity\Entretien $entretien = null)
    {
        $this->entretien = $entretien;

        return $this;
    }

    /**
     * Get entretien
     *
     * @return \SiteBundle\Entity\Entretien
     */
    public function getEntretien()
    {
        return $this->entretien;
    }
}
