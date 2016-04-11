<?php

namespace SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SiteBundle\Entity\EtudiantOffre;

/**
 * EtudiantOffreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EtudiantOffreRepository extends EntityRepository
{
    public function enregistrerOffre($etudiant, $data, $offre)
    {
        if ($this->findOneBy(
                array('Offre' => $offre, 'Etudiant' => $etudiant)
            ) == null
        ) {

            $etudiant_offre = new EtudiantOffre;
            $etudiant_offre->setDate(new \DateTime());
            $etudiant_offre->setLettreMotivation($data['lettreMotivation']);
            $etudiant_offre->setOffre($offre);
            $etudiant_offre->setEtudiant($etudiant);

            $this->_em->persist($etudiant_offre);
            $this->_em->flush();
            return '';
        } else {
            return 'Vous avez déjà postulé à cette offre.';
        }
    }
}
