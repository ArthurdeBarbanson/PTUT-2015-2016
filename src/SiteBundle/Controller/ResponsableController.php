<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\Personne;
use SiteBundle\Entity\User;
use SiteBundle\Forms\Types\AjoutEtudiantImport;
use SiteBundle\Forms\Types\RefuserAnnonce;
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
        $formImport = $this->createForm(AjoutEtudiantImport::class);

        $form->handleRequest($request);
        $formImport->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            //envoie de mail
            $message = new \Swift_Message();
            $message
                ->setSubject('Hello Email')
                ->setFrom('no_reply@ptut.com')
                ->setTo($data['Email'])
                ->setBody(
                    $this->renderView(
                        '@Site/Email/emailInscriptionEtudiant',
                        array('password' => $randomPassword)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            $this->addFlash('success', "l'étudiant à été ajouter !");
        } elseif ($formImport->isSubmitted() && $formImport->isValid()) {
            $data = $formImport->getData();
            if (isset($data['csv'])) {
                $etudiants = $this->chargerEtudiantDepuisCsv($data['csv']);
            }
            $this->addFlash('erreur', "Une erreur est survenu lors de l'ajout des étudiants.");
        } else {
            $this->addFlash('erreur', "Une erreur est survenu lors de l'ajout des étudiants.");
        }


        return $this->render('SiteBundle:Responsable:ajoutEtudiant.html.twig', [
            'form' => $form->createView(),
            'formImport' => $formImport->createView(),
        ]);
    }

    private function chargerEtudiantDepuisCsv($path)
    {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($path);
        $pages = $phpExcelObject->getAllSheets();
        foreach ($pages as $page) {
            $lignes = $page->getRowIterator();
            foreach ($lignes as $ligne) {
                $cellIterator = $ligne->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                foreach ($cellIterator as $cell) {
                    var_dump($cell);
                    die;
                }
            }
        }
        die;
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

        $formulaire = $this->createForm(RefuserAnnonce::class);

        if ($formulaire->handleRequest($request)->isValid()) {

                // en attente serveur smtp

//                $message = \Swift_Message::newInstance()
//                    ->setSubject('Refuse de validation ')
//                    ->setFrom('send@example.com')
//                    ->setTo('recipient@example.com')
//                    ->setBody(
//                        $this->renderView(
//                            'Emails/refusAnnonce.html.twig'
//                        ),
//                        'text/html'
//                    );
//                $this->get('mailer')->send($message);

                $this->addFlash('info', "L'offre à bien été enregistrée.");
                return $this->redirect($this->generateUrl('acceuil_responsable'));

        }

        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig',
            [
                'offre' => $offre,
                'form_Responsable' => $formulaire->createView(),
                'form' => $formulaire->createView(),
                'errorEtudiant' => ''
            ]
        );
    }

    public function validerAnnonceAction(Request $request)
    {
        $offreid = $request->get('offreId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offrevalider = $repository->find($offreid);
        //si l'annonce n'es pas trouvé
        if (null === $offrevalider) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }
        $offrevalider->setEtatOffre('En ligne');

        $em = $this->getDoctrine()->getManager();
        $em->persist($offrevalider);
        $em->flush();

        return $this->redirect($this->generateUrl('acceuil_responsable'));

    }


}
