<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dirigeant
 *
 * @ORM\Table(name="dirigeant")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\DirigeantRepository")
 */
class Dirigeant
{

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\Personne", cascade={"persist"})
     */
    private $laPersone;

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
     * @ORM\Column(name="Fonction", type="string", length=255)
     */
    private $fonction;



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
     * Set fonction
     *
     * @param string $fonction
     * @return Dirigeant
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string 
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Get laPersone
     *
     * @return Personne
     */
    public function getLaPersone()
    {
        return $this->laPersone;
    }

    /**
     * Set laPersone
     *
     * @param Personne $laPersone
     * @return Etudiant
     */
    public function setLaPersone(Personne $laPersone)
    {
        $this->laPersone = $laPersone;
    }
}