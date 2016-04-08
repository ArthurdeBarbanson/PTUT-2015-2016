<?php

namespace SiteBundle\Controller;

use SiteBundle\Forms\Types\AjoutPdfEtu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EtudiantController extends Controller
{
    public function accueilAction(Request $request)
    {
        $error = '';
        $form = $this->createForm(AjoutPdfEtu::class);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $date = new \DateTime();
                $annee = $date->format('Y');
                $dir = 'uploads/cv_etudiant/'.$annee;
                $file = $form['pdf']->getData();
                $extension = $file->guessExtension();
                if($extension == 'pdf'){
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('SiteBundle:Etudiant');

                    $etudiant =$repository->find($this->getUser()->getIdEtudiant());
                    $nom = $etudiant->getLaPersone()->getNom();
                    $file->move($dir, $etudiant->getId().$nom.'.'.$extension);
                    $final_url = $dir.'/'.$etudiant->getId().$nom.'.'.$extension;
                    $etudiant->setCV($final_url);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($etudiant);
                    $em->flush();
                }else{
                    $error = 'Vous devez importer votre CV en format PDF uniquement.';
                }
            }
        }

        return $this->render(
            'SiteBundle:Etudiant:accueil_etudiant.html.twig', [
                'form' => $form->createView(),
                'error' => $error
            ]
        );
    }

}
