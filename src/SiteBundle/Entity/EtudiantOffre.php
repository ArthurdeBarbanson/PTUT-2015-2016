<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantOffre
 *
 * @ORM\Table(name="etudiant_offre")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\EtudiantOffreRepository")
 */
class EtudiantOffre
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
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    
    /**
     * @var string
     *
     * @ORM\Column(name="LettreMotivation", type="text")
     */
    private $lettreMotivation;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Etudiant")
     * @ORM\JoinColumn(name="etudiant_id", referencedColumnName="id")
     */
    private $Etudiant;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\Offre")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id")
     */
    private $Offre;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", columnDefinition="enum('Accepter','Refuser','Attente Entreprise','Attente Etudiant')" ,nullable=true)
     */
    private $etat;



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
     * Set date
     *
     * @param \DateTime $date
     * @return EtudiantOffre
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lettreMotivation
     *
     * @param string $lettreMotivation
     * @return EtudiantOffre
     */
    public function setLettreMotivation($lettreMotivation)
    {
        $this->lettreMotivation = $lettreMotivation;

        return $this;
    }

    /**
     * Get lettreMotivation
     *
     * @return string 
     */
    public function getLettreMotivation()
    {
        return $this->lettreMotivation;
    }

    /**
     * Set Etudiant
     *
     * @param \SiteBundle\Entity\Etudiant $etudiant
     * @return EtudiantOffre
     */
    public function setEtudiant(\SiteBundle\Entity\Etudiant $etudiant)
    {
        $this->Etudiant = $etudiant;

        return $this;
    }

    /**
     * Get Etudiant
     *
     * @return \SiteBundle\Entity\Etudiant 
     */
    public function getEtudiant()
    {
        return $this->Etudiant;
    }


    /**
     * Set Offre
     *
     * @param \SiteBundle\Entity\Offre $offre
     * @return EtudiantOffre
     */
    public function setOffre(\SiteBundle\Entity\Offre $offre)
    {
        $this->Offre = $offre;

        return $this;
    }

    /**
     * Get Offre
     *
     * @return \SiteBundle\Entity\Offre 
     */
    public function getOffre()
    {
        return $this->Offre;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return EtudiantOffre
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
