<?php

namespace SiteBundle\Controller;

use Proxies\__CG__\SiteBundle\Entity\Entreprise;
use Proxies\__CG__\SiteBundle\Entity\Offre;
use SiteBundle\Entity\Adresse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteBundle:Default:index.html.twig');
    }
    public function testAction()
    {
        return $this->render('SiteBundle:Default:test.html.twig');
    }

    public function detailAnnonceAction($annonceId){
        $offre = new Offre();
        //initialisation adresse
        $adresse = new Adresse();
        $adresse->setAdresse("ici c'est paris");
        $adresse->setCodePostal("01000");
        $adresse->setCommune("Bourg en bresse");
        $adresse->setPays("FRANCE");

        //initialisation entreprise
        $entreprise = new Entreprise();
        $entreprise->setDescription("Une entreprise qui est jolie parfois");
        $entreprise->setNom("CorespondantNom");
        $entreprise->setPrenom("CorespondantPrenom");
        $entreprise->setTelephone("04.14.14.14.14");
        $entreprise->setMail("dfsdfsd@gfgsdf.fr");
        $entreprise->setAdresse($adresse);
        $entreprise->setRaisonSocial("RaisonSocial");
        
        //initialisation offre
        $offre->setSujet("Un sujet passionnant");
        $offre->setEntreprise($entreprise);
        

        //si l'annonce n'es pas trouvé
        if (null === "") {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }


        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig'
            ,['offre' => $offre
            ,'annonceId' => $annonceId]
        );
    }
}
