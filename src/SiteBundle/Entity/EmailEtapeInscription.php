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
     * @ORM\Column(name="etape1", type="text", unique=true)
     */
    private $etape1;

    /**
     * @var string
     *
     * @ORM\Column(name="etape2", type="text", unique=true)
     */
    private $etape2;

    /**
     * @var string
     *
     * @ORM\Column(name="etape3", type="text", unique=true)
     */
    private $etape3;

    /**
     * @var string
     *
     * @ORM\Column(name="etape4", type="text", unique=true)
     */
    private $etape4;

    /**
     * @var string
     *
     * @ORM\Column(name="etape5", type="text", unique=true)
     */
    private $etape5;

    /**
     * @var string
     *
     * @ORM\Column(name="etape6", type="text", unique=true)
     */
    private $etape6;


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
     * Set etape1
     *
     * @param string $etape1
     *
     * @return EmailEtapeInscription
     */
    public function setEtape1($etape1)
    {
        $this->etape1 = $etape1;

        return $this;
    }

    /**
     * Get etape1
     *
     * @return string
     */
    public function getEtape1()
    {
        return $this->etape1;
    }

    /**
     * Set etape2
     *
     * @param string $etape2
     *
     * @return EmailEtapeInscription
     */
    public function setEtape2($etape2)
    {
        $this->etape2 = $etape2;

        return $this;
    }

    /**
     * Get etape2
     *
     * @return string
     */
    public function getEtape2()
    {
        return $this->etape2;
    }

    /**
     * Set etape3
     *
     * @param string $etape3
     *
     * @return EmailEtapeInscription
     */
    public function setEtape3($etape3)
    {
        $this->etape3 = $etape3;

        return $this;
    }

    /**
     * Get etape3
     *
     * @return string
     */
    public function getEtape3()
    {
        return $this->etape3;
    }

    /**
     * Set etape4
     *
     * @param string $etape4
     *
     * @return EmailEtapeInscription
     */
    public function setEtape4($etape4)
    {
        $this->etape4 = $etape4;

        return $this;
    }

    /**
     * Get etape4
     *
     * @return string
     */
    public function getEtape4()
    {
        return $this->etape4;
    }

    /**
     * Set etape5
     *
     * @param string $etape5
     *
     * @return EmailEtapeInscription
     */
    public function setEtape5($etape5)
    {
        $this->etape5 = $etape5;

        return $this;
    }

    /**
     * Get etape5
     *
     * @return string
     */
    public function getEtape5()
    {
        return $this->etape5;
    }

    /**
     * Set etape6
     *
     * @param string $etape6
     *
     * @return EmailEtapeInscription
     */
    public function setEtape6($etape6)
    {
        $this->etape6 = $etape6;

        return $this;
    }

    /**
     * Get etape6
     *
     * @return string
     */
    public function getEtape6()
    {
        return $this->etape6;
    }
}
