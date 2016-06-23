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
     * @ORM\Column(name="etape", type="string", columnDefinition="enum('1', '2', '3','4','5','6')" ,nullable=false)
     */

    private $etape;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text",nullable=true)
     */

    private $body;

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


    /**
     * Set body
     *
     * @param string $body
     *
     * @return EmailEtapeInscription
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
