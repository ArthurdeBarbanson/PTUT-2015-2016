<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EtudiantController extends Controller
{
    public function accueilAction(Request $request)
    {
        return $this->render(
            'SiteBundle:Etudiant:accueil_etudiant.html.twig'
        );
    }

}
