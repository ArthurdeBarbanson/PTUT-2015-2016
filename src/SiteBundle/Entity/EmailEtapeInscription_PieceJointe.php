<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailEtapeInscription_PieceJointe
 *
 * @ORM\Table(name="email_etape_inscription__piece_jointe")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\EmailEtapeInscription_PieceJointeRepository")
 */
class EmailEtapeInscription_PieceJointe
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
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\EmailEtapeInscription")
     * @ORM\JoinColumn(name="email_etape_inscription_id", referencedColumnName="id")
     */
    private $EmailEtapeInscription;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\EmailEtapeInscription")
     * @ORM\JoinColumn(name="piece_jointe_id", referencedColumnName="id")
     */
    private $PieceJointe;

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
     * Set emailEtapeInscription
     *
     * @param \SiteBundle\Entity\EmailEtapeInscription $emailEtapeInscription
     *
     * @return EmailEtapeInscription_PieceJointe
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

    /**
     * Set pieceJointe
     *
     * @param \SiteBundle\Entity\EmailEtapeInscription $pieceJointe
     *
     * @return EmailEtapeInscription_PieceJointe
     */
    public function setPieceJointe(\SiteBundle\Entity\EmailEtapeInscription $pieceJointe = null)
    {
        $this->PieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return \SiteBundle\Entity\EmailEtapeInscription
     */
    public function getPieceJointe()
    {
        return $this->PieceJointe;
    }
}
