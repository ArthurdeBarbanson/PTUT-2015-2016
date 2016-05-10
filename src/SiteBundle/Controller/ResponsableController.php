<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\Personne;
use SiteBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Forms\Types\AjoutEtudiant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResponsableController extends Controller
{
    public function accueilAction()
    {
        $repositoryOffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offres=$repositoryOffre->findBy(["etatOffre" => "En attente de validation"]);


        return $this->render('SiteBundle:Responsable:accueil_responsable.html.twig',[
            'offres' => $offres
        ]);
    }

    public function ajoutEtudiantAction(Request $request)
    {
        $form = $this->createForm(AjoutEtudiant::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $randomPassword = random_bytes(10);

            //set personne
            $personne = new Personne();
            $personne->setNom($data['Nom']);
            $personne->setPrenom($data['Prenom']);
            $personne->setMail($data['Email']);
            $personne->setIsAdmin(false);
            //set etudiant
            $etudiant = new Etudiant();
            $etudiant->setLaPersone($personne);
            //set user
            $user = new User();
            $user->setUsername($data['Email']);
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $randomPassword);
            $user->setPassword($encoded);
            $user->setIdEtudiant($etudiant);
            $user->setRoles(array('ROLE_ETUDIANT'));
            $em->persist($user);

            $em->flush();
            $this->addFlash('success', "l'étudiant à été ajouter !");
        } else {
            $this->addFlash('erreur', "Une erreur est survenu lors de l'ajout d'un étudiant.");
        }


        return $this->render('SiteBundle:Responsable:ajoutEtudiant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function detailAnnonceAction(Request $request)
    {
        $offreid = $request->get('offreId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offre = $repository->find($offreid);
        //si l'annonce n'es pas trouvé
        if (null === $offre) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }

        $form = $this->createForm(PostulerAnnonce::class);
        $error = '';

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $offreEtudiantRepository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('SiteBundle:EtudiantOffre');
                $error = $offreEtudiantRepository->enregistrerOffre(
                    $this->getUser()->getIdEtudiant()
                    , $form->getData()
                    , $offre);
                $this->addFlash('info', "L'offre à bien été enregistrée.");
            }
        }

        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig',
             [
                 'offre' => $offre,
                'form' => $form->createView(),
                 'errorEtudiant' => $error
            ]
        );
    }


}
