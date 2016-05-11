<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Adresse;
use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\Personne;
use SiteBundle\Entity\User;
use SiteBundle\Forms\Types\AjoutEtudiantImport;
use SiteBundle\Forms\Types\AjoutTuteur;
use SiteBundle\Forms\Types\AssignerTuteur;
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

        $repositoryEtudiant = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');

        $offres = $repositoryOffre->findBy(["etatOffre" => "En attente de validation"]);
        $etudiants = $repositoryEtudiant->findAll();

        return $this->render('SiteBundle:Responsable:accueil_responsable.html.twig', [
            'offres' => $offres,
            'etudiants' => $etudiants
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
                $etudiants = $this->chargerEtudiantDepuisExcel($data['csv']);
                foreach ($etudiants as $etudiant) {
                    $em = $this->getDoctrine()->getManager();
                    //setPassword
                    $randomPassword = random_bytes(10);
                    //set user
                    $user = new User();
                    $user->setUsername($etudiant->getLaPersone()->getMail());
                    $encoder = $this->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($user, $randomPassword);
                    $user->setPassword($encoded);
                    $user->setIdEtudiant($etudiant);
                    $user->setRoles(array('ROLE_ETUDIANT'));

                    $em->persist($user);
                    var_dump($user->getIdEtudiant()->getDateNaissance());
                    die;
                    $em->flush();

                    //envoie de mail
                    //TODO envoie mail
                    /*$message = new \Swift_Message();
                    $message
                        ->setSubject('Hello Email')
                        ->setFrom('no_reply@ptut.com')
                        ->setTo($etudiant->getLaPersone()->getMail())
                        ->setBody(
                            $this->renderView(
                                '@Site/Email/emailInscriptionEtudiant',
                                array('password' => $randomPassword)
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);*/
                }

            }
        } else {
            $this->addFlash('erreur', "Une erreur est survenu lors de l'ajout des étudiants.");
        }

        return $this->render('SiteBundle:Responsable:ajoutEtudiant.html.twig', [
            'form' => $form->createView(),
            'formImport' => $formImport->createView(),
        ]);
    }

    private function chargerEtudiantDepuisExcel($path)
    {
        $etudiants = array();
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($path);
        $pages = $phpExcelObject->getAllSheets();
        foreach ($pages as $page) {
            $lignes = $page->getRowIterator();
            foreach ($lignes as $ligne) {
                $rowIndex = $ligne->getRowIndex();
                if ($rowIndex == 1)
                    continue;
                $nom = $page->getCell('B' . $rowIndex)->getValue();
                $prenom = $page->getCell('D' . $rowIndex)->getValue();
                $adresseText = $page->getCell('E' . $rowIndex)->getValue();
                $code_postal = $page->getCell('F' . $rowIndex)->getValue();
                $commune = $page->getCell('G' . $rowIndex)->getValue();
                $pays = $page->getCell('H' . $rowIndex)->getValue();
                $mail = $page->getCell('L' . $rowIndex)->getValue();
                $telephone = $page->getCell('O' . $rowIndex)->getValue();
                $date_naissance = \DateTime::createFromFormat('d.m.y', trim($page->getCell('S' . $rowIndex)->getValue()));
                var_dump($date_naissance);
                $num_dossier = $page->getCell('R' . $rowIndex)->getValue();

                //adresse
                $adresse = new Adresse();
                $adresse->setAdresse($adresseText);
                $adresse->setCodePostal($code_postal);
                $adresse->setCommune($commune);
                $adresse->setPays($pays);

                //personne
                $personne = new Personne();
                $personne->setNom($nom);
                $personne->setPrenom($prenom);
                $personne->setAdresse($adresse);
                $personne->setisTuteur(false);
                $personne->setMail($mail);
                $personne->setTelephone($telephone);

                //etudiant
                $etudiant = new Etudiant();
                $etudiant->setDateNaissance($date_naissance);
                $etudiant->setLaPersone($personne);
                $etudiant->setNumeroDossierCandidature($num_dossier);

                array_push($etudiants, $etudiant);
            }
        }
        return $etudiants;
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

    private function ajouterTripletteAction(request $request)
    {
        $modal = false;
        $repositoryTuteur = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');

        $tuteurs = $repositoryTuteur->findBy(["isTuteur" => "1"]);
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(AjoutTuteur::class);
        $assign = $this->createForm(AssignerTuteur::class);
        if ($request->isMethod('post')) {

            $assign->handleRequest($request);
            if ($assign->get('submit')->isClicked()) {
                $etudiantid = $request->get('etudiantId');
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('SiteBundle:Etudiant');

                $etu = $repository->find($etudiantid);
                $tuteur = $repositoryTuteur->find($request->get('tuteur'));
                $etu->setleTuteur($tuteur);
                return $this->redirect($this->generateUrl('acceuil_responsable'));
            }

            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $repositoryAdresse = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('SiteBundle:Adresse');

                $adresse = $repositoryAdresse->find(2);

                $tuteur = new Personne();
                $tuteur->setSexe($data['Civilite']);
                $tuteur->setPrenom($data['Prenom']);
                $tuteur->setNom($data['Nom']);
                $tuteur->setMail($data['Email']);
                $tuteur->setTelephone($data['Tel']);
                $tuteur->setAdresse($adresse);
                $tuteur->setisTuteur(1);

                $em->persist($tuteur);
                $em->flush();
                $this->addFlash('info', "L'annonce a été mis en attente de Validation.");

                return $this->redirect($this->generateUrl('acceuil_responsable'));

            } else {
                $modal = true;
                return $this->render(
                    'SiteBundle:Responsable:ajoutTueur.html.twig',
                    ['form' => $form->createView(), '$tuteurs' => $tuteurs, 'bool' => $modal]
                );

            }
        }

        return $this->render(
            'SiteBundle:Responsable:ajoutTueur.html.twig',
            ['form' => $form->createView(), '$tuteurs' => $tuteurs, 'bool' => $modal]
        );
    }
}
