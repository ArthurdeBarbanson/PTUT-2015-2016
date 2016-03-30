<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriptionAutreEtablissement
 *
 * @ORM\Table(name="inscription_autre_etablissement")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\InscriptionAutreEtablissementRepository")
 */
class InscriptionAutreEtablissement
{

    /**
     * @ORM\ManyToOne(targetEntity="SiteBundle\Entity\DossierInscription")
     * @ORM\JoinColumn(nullable=false)
     */
    private $DossierInscription;

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
     * @ORM\Column(name="estInscrit", type="boolean")
     */
    private $estInscrit;

    /**
     * @var string
     *
     * @ORM\Column(name="NomEtablissement", type="string", length=255)
     */
    private $nomEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeEtablissement", type="string", length=255)
     */
    private $typeEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="DepartmentEtablissement", type="string", length=255)
     */
    private $departmentEtablissement;

    /**
     * @var bool
     *
     * @ORM\Column(name="estInscriptionMaintenu", type="boolean")
     */
    private $estInscriptionMaintenu;

    /**
     * @var string
     *
     * @ORM\Column(name="AnneeEtablissement", type="string", length=255)
     */
    private $anneeEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeEtablissement", type="string", length=255)
     */
    private $codeEtablissement;


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
     * Set estInscrit
     *
     * @param boolean $estInscrit
     * @return InscriptionAutreEtablissement
     */
    public function setEstInscrit($estInscrit)
    {
        $this->estInscrit = $estInscrit;

        return $this;
    }

    /**
     * Get estInscrit
     *
     * @return boolean 
     */
    public function getEstInscrit()
    {
        return $this->estInscrit;
    }

    /**
     * Set nomEtablissement
     *
     * @param string $nomEtablissement
     * @return InscriptionAutreEtablissement
     */
    public function setNomEtablissement($nomEtablissement)
    {
        $this->nomEtablissement = $nomEtablissement;

        return $this;
    }

    /**
     * Get nomEtablissement
     *
     * @return string 
     */
    public function getNomEtablissement()
    {
        return $this->nomEtablissement;
    }

    /**
     * Set typeEtablissement
     *
     * @param string $typeEtablissement
     * @return InscriptionAutreEtablissement
     */
    public function setTypeEtablissement($typeEtablissement)
    {
        $this->typeEtablissement = $typeEtablissement;

        return $this;
    }

    /**
     * Get typeEtablissement
     *
     * @return string 
     */
    public function getTypeEtablissement()
    {
        return $this->typeEtablissement;
    }

    /**
     * Set departmentEtablissement
     *
     * @param string $departmentEtablissement
     * @return InscriptionAutreEtablissement
     */
    public function setDepartmentEtablissement($departmentEtablissement)
    {
        $this->departmentEtablissement = $departmentEtablissement;

        return $this;
    }

    /**
     * Get departmentEtablissement
     *
     * @return string 
     */
    public function getDepartmentEtablissement()
    {
        return $this->departmentEtablissement;
    }

    /**
     * Set estInscriptionMaintenu
     *
     * @param boolean $estInscriptionMaintenu
     * @return InscriptionAutreEtablissement
     */
    public function setEstInscriptionMaintenu($estInscriptionMaintenu)
    {
        $this->estInscriptionMaintenu = $estInscriptionMaintenu;

        return $this;
    }

    /**
     * Get estInscriptionMaintenu
     *
     * @return boolean 
     */
    public function getEstInscriptionMaintenu()
    {
        return $this->estInscriptionMaintenu;
    }

    /**
     * Set anneeEtablissement
     *
     * @param string $anneeEtablissement
     * @return InscriptionAutreEtablissement
     */
    public function setAnneeEtablissement($anneeEtablissement)
    {
        $this->anneeEtablissement = $anneeEtablissement;

        return $this;
    }

    /**
     * Get anneeEtablissement
     *
     * @return string 
     */
    public function getAnneeEtablissement()
    {
        return $this->anneeEtablissement;
    }

    /**
     * Set codeEtablissement
     *
     * @param string $codeEtablissement
     * @return InscriptionAutreEtablissement
     */
    public function setCodeEtablissement($codeEtablissement)
    {
        $this->codeEtablissement = $codeEtablissement;

        return $this;
    }

    /**
     * Get codeEtablissement
     *
     * @return string 
     */
    public function getCodeEtablissement()
    {
        return $this->codeEtablissement;
    }


    /**
     * Get DossierInscription
     *
     * @return DossierInscription
     */
    public function getDossierInscription()
    {
        return $this->DossierInscription;
    }


    public function setDossierInscription($DossierInscription)
    {
        $this->DossierInscription = $DossierInscription;
    }


}
