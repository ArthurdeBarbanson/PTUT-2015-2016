<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailEtapeInscription
 *
 * @ORM\Table(name="email_etape_inscription")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\EmailEtapeInscriptionRepository")
 */
class EmailEtapeInscription
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
     * @ORM\Column(name="etape", type="string", columnDefinition="enum('Etape 1', 'Etape 2', 'Etape 3','Etape 4','Etape 5','Etape 6')" ,nullable=true)
     */
    private $etape;


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
     * Set etape
     *
     * @param string $etape
     *
     * @return EmailEtapeInscription
     */
    public function setEtape($etape)
    {
        $this->etape = $etape;

        return $this;
    }

    /**
     * Get etape
     *
     * @return string
     */
    public function getEtape()
    {
        return $this->etape;
    }
}
