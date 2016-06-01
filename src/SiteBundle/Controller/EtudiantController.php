<?php

namespace SiteBundle\Controller;

use SiteBundle\Forms\Types\AjoutPdfEtu;
use SiteBundle\Forms\Types\FichePreInscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtudiantController extends Controller
{
    public function accueilAction(Request $request)
    {
        $error = '';
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');
        $repository2 = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');
        $repository3 = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Entreprise');

        $etudiant = $repository->find($this->getUser()->getIdEtudiant());
        $offre  = $repository2->findBy(['Etudiant' => $this->getUser()->getIdEtudiant()]);

        if(!empty($offre[0])){
            $entreprise = $repository3->find($offre[0]->getEntreprise()->getId());
        }else{
            $entreprise = null;
        }


        $form = $this->createForm(AjoutPdfEtu::class);
        $formPreInscription = $this->createForm(FichePreInscription::class);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $date = new \DateTime();
                $annee = $date->format('Y');
                $dir = 'uploads/cv_etudiant/' . $annee;
                $file = $form['pdf']->getData();
                $extension = $file->guessExtension();
                if ($extension == 'pdf') {
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('SiteBundle:Etudiant');

                    $etudiant = $repository->find($this->getUser()->getIdEtudiant());
                    $uniqId = uniqid();
                    $file->move($dir, $etudiant->getId() . '_' . $uniqId . '.' . $extension);
                    $final_url = $dir . '/' . $etudiant->getId() . '_' . $uniqId . '.' . $extension;
                    $etudiant->setCV($final_url);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($etudiant);
                    $em->flush();
                } else {
                    $error = 'Vous devez importer votre CV en format PDF uniquement.';
                }
            }

        }

        return $this->render(
            'SiteBundle:Etudiant:accueil_etudiant.html.twig', [
                'form2' => $form->createView(),
                'error' => $error,
                'etudiant' => $etudiant,
                'formPreInscription' => $formPreInscription->createView(),
                'entreprise' => $entreprise
            ]
        );
    }

    public function detailsEntrepriseAction(Request $request)
    {

        $entrepriseId = $request->get('entrepriseId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Entreprise');

        $entreprise = $repository->find($entrepriseId);
        //si l'annonce n'es pas trouvé
        if (null === $entreprise) {
            throw new NotFoundHttpException("L'entreprise n'a pas été trouvée.");
        }

        return $this->render(
            'SiteBundle:Etudiant:detailsEntreprise.html.twig', ['entreprise' => $entreprise]
        );

    }

    public function listeOffrePostulerAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');

        $etudiant = $repository->find($this->getUser()->getIdEtudiant());

        $repositoryPostulant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:EtudiantOffre');
        $offresP = $repositoryPostulant->findBy(array("Etudiant" => $etudiant, "etat" => "Attente Entreprise"));
        $offresV = $repositoryPostulant->findBy(array("Etudiant" => $etudiant, "etat" => "Attente Etudiant"));
        $offresR = $repositoryPostulant->findBy(array("Etudiant" => $etudiant, "etat" => "Refuser"));

        return $this->render(
            'SiteBundle:Etudiant:liste_offre_postuler_Etudiant.html.twig', [
                'offresP' =>  $offresP,
                'offresR' =>   $offresR,
                'offresV' =>   $offresV,
            ]
        );
    }
}
