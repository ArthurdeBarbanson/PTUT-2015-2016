<?php

namespace SiteBundle\Controller;

use SiteBundle\Forms\Types\AjoutPdfEtu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EtudiantController extends Controller
{
    public function accueilAction(Request $request)
    {
        $form = $this->createForm(AjoutPdfEtu::class);
        return $this->render(
            'SiteBundle:Etudiant:accueil_etudiant.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

}
