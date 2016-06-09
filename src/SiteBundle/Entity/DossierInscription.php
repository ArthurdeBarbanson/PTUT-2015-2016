<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DossierInscription
 *
 * @ORM\Table(name="dossier_inscription")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DossierInscriptionRepository")
 */
class DossierInscription
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
     * @ORM\Column(name="estSportifDeHautNiveau", type="boolean")
     */
    private $estSportifDeHautNiveau = false;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", columnDefinition="enum('0','1','2','3','4','5')" ,nullable=true , options={"default":"0"})
     */
    private $etatDossier;

    /**
     * @var bool
     *
     * @ORM\Column(name="Handicap", type="boolean")
     */
    private $handicap = false;

    /**
     * @var string
     *
     * @ORM\Column(name="SituationFamillale", type="string", length=50, nullable=true)
     */
    private $situationFamillale;

    /**
     * @var string
     *
     * @ORM\Column(name="INE", type="string", length=50, nullable=true)
     */
    private $iNE;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ancienDeLyon1", type="boolean", nullable=true)
     */
    private $ancienDeLyon1;

    /**
     * @var string
     *
     * @ORM\Column(name="NumeroSecuriteSocial", type="string", length=50, nullable=true)
     */
    private $numeroSecuriteSocial;


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
     * Set estSportifDeHautNiveau
     *
     * @param boolean $estSportifDeHautNiveau
     * @return DossierInscription
     */
    public function setEstSportifDeHautNiveau($estSportifDeHautNiveau)
    {
        $this->estSportifDeHautNiveau = $estSportifDeHautNiveau;

        return $this;
    }

    /**
     * Get estSportifDeHautNiveau
     *
     * @return boolean 
     */
    public function getEstSportifDeHautNiveau()
    {
        return $this->estSportifDeHautNiveau;
    }

    /**
     * Set etatDossier
     *
     * @param string $etatDossier
     * @return DossierInscription
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
     * Set handicap
     *
     * @param boolean $handicap
     * @return DossierInscription
     */
    public function setHandicap($handicap)
    {
        $this->handicap = $handicap;

        return $this;
    }

    /**
     * Get handicap
     *
     * @return boolean 
     */
    public function getHandicap()
    {
        return $this->handicap;
    }

    /**
     * Set situationFamillale
     *
     * @param string $situationFamillale
     * @return DossierInscription
     */
    public function setSituationFamillale($situationFamillale)
    {
        $this->situationFamillale = $situationFamillale;

        return $this;
    }

    /**
     * Get situationFamillale
     *
     * @return string 
     */
    public function getSituationFamillale()
    {
        return $this->situationFamillale;
    }

    /**
     * Set iNE
     *
     * @param string $iNE
     * @return DossierInscription
     */
    public function setINE($iNE)
    {
        $this->iNE = $iNE;

        return $this;
    }

    /**
     * Get iNE
     *
     * @return string 
     */
    public function getINE()
    {
        return $this->iNE;
    }

    /**
     * Set ancienDeLyon1
     *
     * @param string $ancienDeLyon1
     * @return DossierInscription
     */
    public function setAncienDeLyon1($ancienDeLyon1)
    {
        $this->ancienDeLyon1 = $ancienDeLyon1;

        return $this;
    }

    /**
     * Get ancienDeLyon1
     *
     * @return string 
     */
    public function getAncienDeLyon1()
    {
        return $this->ancienDeLyon1;
    }

    /**
     * Set numeroSecuriteSocial
     *
     * @param string $numeroSecuriteSocial
     * @return DossierInscription
     */
    public function setNumeroSecuriteSocial($numeroSecuriteSocial)
    {
        $this->numeroSecuriteSocial = $numeroSecuriteSocial;

        return $this;
    }

    /**
     * Get numeroSecuriteSocial
     *
     * @return string 
     */
    public function getNumeroSecuriteSocial()
    {
        return $this->numeroSecuriteSocial;
    }
}
