<?php

namespace SiteBundle\Controller;

use Proxies\__CG__\SiteBundle\Entity\Entreprise;
use Proxies\__CG__\SiteBundle\Entity\Offre;
use SiteBundle\Forms\Types\CreateAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        //initialisation entreprise
        $entreprise = new Entreprise();
        $entreprise->setDescription("Une entreprise qui est jolie parfois");
        $entreprise->setNom("Nom de l'entreprise");
        
        //initialisation offre
        $offre->setSujet("Un sujet passionnant");
        

        //si l'annonce n'es pas trouvé
        if (null === "") {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }


        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig'
            ,['offre' => $offre
            ,'annonceId' => $annonceId
            ,'entreprise' => $entreprise]
        );
    }
}
