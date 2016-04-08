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

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $date = new \DateTime();
                $annee = $date->format('Y');
                $dir = 'uploads/cv_etudiant/'.$annee;
                $file = $form['pdf']->getData();
                $extension = $file->guessExtension();
                if (!$extension) {
                    // extension cannot be guessed
                    $extension = 'bin';
                }
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('SiteBundle:Etudiant');

                $etudiant =$repository->find($this->getUser()->getIdEtudiant());
                $file->move($dir, $etudiant->getLaPersone()->getNom().'.'.$extension);
            }
        }

        return $this->render(
            'SiteBundle:Etudiant:accueil_etudiant.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

}
