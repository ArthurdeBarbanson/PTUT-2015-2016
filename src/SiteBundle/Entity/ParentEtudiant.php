<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParentEtudiant
 *
 * @ORM\Table(name="parentEtudiant")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\ParentEtudiantRepository")
 */
class ParentEtudiant
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
     * @ORM\Column(name="CategorieSocioProfessionnelle", type="string", length=255)
     */
    private $categorieSocioProfessionnelle;

    /**
     * @var string
     *
     * @ORM\Column(name="SecuriteSocial", type="string", length=255)
     */
    private $securiteSocial;


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
     * Set categorieSocioProfessionnelle
     *
     * @param string $categorieSocioProfessionnelle
     * @return ParentEtudiant
     */
    public function setCategorieSocioProfessionnelle($categorieSocioProfessionnelle)
    {
        $this->categorieSocioProfessionnelle = $categorieSocioProfessionnelle;

        return $this;
    }

    /**
     * Get categorieSocioProfessionnelle
     *
     * @return string 
     */
    public function getCategorieSocioProfessionnelle()
    {
        return $this->categorieSocioProfessionnelle;
    }

    /**
     * Set securiteSocial
     *
     * @param string $securiteSocial
     * @return ParentEtudiant
     */
    public function setSecuriteSocial($securiteSocial)
    {
        $this->securiteSocial = $securiteSocial;

        return $this;
    }

    /**
     * Get securiteSocial
     *
     * @return string 
     */
    public function getSecuriteSocial()
    {
        return $this->securiteSocial;
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
