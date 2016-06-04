<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\EmailRepository")
 */
class Email
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
     * @ORM\Column(name="host", type="string", length=255, unique=true)
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="transport", type="string", length=255, unique=true)
     */
    private $transport;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, unique=true)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="port", type="integer", nullable=true, unique=true)
     */
    private $port;

    /**
     * @ORM\OneToOne(targetEntity="SiteBundle\Entity\EmailEtapeInscription", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $etapeliste;


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
     * Set host
     *
     * @param string $host
     *
     * @return Email
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set transport
     *
     * @param string $transport
     *
     * @return Email
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return string
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Email
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Email
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set port
     *
     * @param integer $port
     *
     * @return Email
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set etapeliste
     *
     * @param \SiteBundle\Entity\EmailEtapeInscription $etapeliste
     *
     * @return Email
     */
    public function setEtapeliste(\SiteBundle\Entity\EmailEtapeInscription $etapeliste = null)
    {
        $this->etapeliste = $etapeliste;

        return $this;
    }

    /**
     * Get etapeliste
     *
     * @return \SiteBundle\Entity\EmailEtapeInscription
     */
    public function getEtapeliste()
    {
        return $this->etapeliste;
    }
}
