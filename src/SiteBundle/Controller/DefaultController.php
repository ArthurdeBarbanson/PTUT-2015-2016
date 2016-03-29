<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteBundle:Default:index.html.twig');
    }

    public function ajoutAnnonceAction(){

        return $this->render('SiteBundle:Default:ajoutAnnonce.html.twig');
    }


}
