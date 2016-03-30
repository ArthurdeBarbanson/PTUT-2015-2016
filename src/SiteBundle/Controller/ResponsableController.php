<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResponsableController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function ajoutEtudiantAction()
    {
        return $this->render('SiteBundle:Responsable:ajoutEtudiant.html.twig');
    }
}
