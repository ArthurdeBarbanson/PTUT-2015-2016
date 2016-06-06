<?php

namespace SiteBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use SiteBundle\Entity\Adresse;
use SiteBundle\Entity\DossierInscription;
use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\Personne;
use SiteBundle\Entity\User;
use SiteBundle\Entity\EmailEtapeInscription;

use SiteBundle\Forms\Types\AjoutEtudiantImport;
use SiteBundle\Forms\Types\AjoutTuteur;
use SiteBundle\Forms\Types\AssignerTuteur;
use SiteBundle\Forms\Types\EmailEtapeInscriptionType;
use SiteBundle\Forms\Types\ModifierAnnonceType;
use SiteBundle\Forms\Types\RefuserAnnonceType;
use SiteBundle\Forms\Types\SMTPType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Forms\Types\AjoutEtudiant;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SiteBundle\Forms\Types\ResponsableAjoutResponsableType;

class ResponsableController extends Controller
{
    public function accueilAction()
    {
        $typeLp= $this->getUser()->getTypeLicence();

        $repositoryOffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $repositoryEtudiant = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');

        switch($typeLp){
            case 'METINET':
                $offres = $repositoryOffre->findBy(['licenceConcerne'=>'METINET']);
                $etudiants = $repositoryEtudiant->findBy(['typeLicence'=>'METINET']);
                break;

            case 'IEM':
                $offres = $repositoryOffre->findBy(['licenceConcerne'=>'IEM']);
                $etudiants = $repositoryEtudiant->findBy(['typeLicence'=>'IEM']);
                break;

            default:
                $etudiants = $repositoryEtudiant->findAll();
                $offres = $repositoryOffre->findAll();
                break;
        }

        $smtpForm = $this->createForm(SMTPType::class);

        return $this->render('SiteBundle:Responsable:accueil_responsable.html.twig', [
            'offres' => $offres,
            'etudiants' => $etudiants,
            'smtp_form' => $smtpForm->createView()
        ]);
    }

    public function ajouterNouveauResponsableLicenceAction(Request $request)
    {

        $form = $this->createForm(ResponsableAjoutResponsableType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $randomPassword = random_bytes(10);
            //set user
            $user = new User();
            $user->setUsername($data['Email']);
            $user->setTypeLicence($data['Lpconcerne']);
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $randomPassword);
            $user->setPassword($encoded);
            $user->setRoles(array('ROLE_ADMIN'));
            $em->persist($user);

            try {
                $em->flush();
                $message = new \Swift_Message();
                $message
                    ->setSubject('Inscription')
                    ->setFrom('no_reply@ptut.com')
                    ->setTo($data['Email'])
                    ->setBody(
                        $this->renderView(
                            ':Emails:ajoutResponsable.html.twig',
                            array('password' => $randomPassword)
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);

                $this->addFlash('success', "Le responsable a été ajouter !");
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('error', $data['Email'] . " est déjà associée à un autre compte.");
            }
        }

        return $this->render('SiteBundle:Responsable:ajouterResponsableLicence.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function ajoutEtudiantAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $promos = $em->getRepository('SiteBundle:Session')->findAll();
        $form = $this->createForm(AjoutEtudiant::class, $promos);
        $formImport = $this->createForm(AjoutEtudiantImport::class, $promos);

        $form->handleRequest($request);
        $formImport->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $randomPassword = random_bytes(10);

            //set personne
            $personne = new Personne();
            $personne->setNom($data['Nom']);
            $personne->setPrenom($data['Prenom']);
            $personne->setMail($data['Email']);

            //dossier
            $dossier = new DossierInscription();
            $dossier->setEtatDossier(0);

            //set etudiant
            $etudiant = new Etudiant();
            $etudiant->setLaPersone($personne);
            $etudiant->setTypeLicence($data['Lpconcerne']);
            $etudiant->setInscription($dossier);
            $etudiant->setSession($data['promo']);
            //set user
            $user = new User();
            $user->setUsername($data['Email']);
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $randomPassword);
            $user->setPassword($encoded);
            $user->setIdEtudiant($etudiant);
            $user->setRoles(array('ROLE_ETUDIANT'));
            $em->persist($user);

            try {
                $em->flush();
                $this->addFlash('success', "L'étudiant a été ajouter !");
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('error', $data['Email'] . " est déjà associée à un autre compte.");
            }

        } elseif ($formImport->isSubmitted() && $formImport->isValid()) {
            $data = $formImport->getData();
            if (isset($data['csv'])) {
                $etudiants = $this->chargerEtudiantDepuisExcel($data['csv']);
                $repositoryUser = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('SiteBundle:User');
                $nombreUserExistantDeja = 0;
                foreach ($etudiants as $etudiant) {
                    $user = $repositoryUser->findBy(array("username" => $etudiant->getLaPersone()->getMail()));
                    if (count($user) != 0) {
                        $nombreUserExistantDeja++;
                    } else {
                        $em = $this->getDoctrine()->getManager();
                        //setPassword
                        $randomPassword = random_bytes(10);
                        //set user
                        $user = new User();
                        $etudiant->setSession($data['promo']);
                        $user->setUsername($etudiant->getLaPersone()->getMail());
                        $encoder = $this->get('security.password_encoder');
                        $encoded = $encoder->encodePassword($user, $randomPassword);
                        $user->setPassword($encoded);
                        $user->setIdEtudiant($etudiant);
                        $user->setRoles(array('ROLE_ETUDIANT'));

                        $em->persist($user);
                        try {
                            $em->flush();
                            if ($nombreUserExistantDeja > 0) {
                                $this->addFlash('success', $nombreUserExistantDeja . "étudiants n'ont pas été enregistrer car ils existaient déjà. Les autres étudiants on été ajoutés avec succès.");
                            } else {
                                $this->addFlash('success', "Les étudiants on été ajoutés avec succès.");
                            }
                        } catch (Exception $exception) {
                            $this->addFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
                        }
                    }
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
                $date_naissance = \DateTime::createFromFormat('d/m/Y', trim($page->getCell('S' . $rowIndex)->getValue()));

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

                //dossier
                $dossier = new DossierInscription();
                $dossier->setEtatDossier(0);

                //etudiant
                $etudiant = new Etudiant();
                $etudiant->setDateNaissance($date_naissance);
                $etudiant->setLaPersone($personne);
                $etudiant->setInscription($dossier);

                array_push($etudiants, $etudiant);
            }
        }
        return $etudiants;
    }

    public function detailAnnonceAction(Request $request)
    {
        $errors_refus = '';
        $errors_modif = '';


        $offreid = $request->get('offreId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $em = $this->getDoctrine()->getManager();

        $offre = $repository->find($offreid);
        //si l'annonce n'es pas trouvé
        if (null === $offre) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }

        $formulaire = $this->createForm(RefuserAnnonceType::class);
        $formModifier = $this->createForm(ModifierAnnonceType::class);
        $form = $this->createForm(AjoutEtudiant::class);

        $formModifier->handleRequest($request);
        if ($formModifier->isSubmitted() && $formModifier->isValid()) {
            $data = $formModifier->getData();
            // en attente serveur smtp

            $message = \Swift_Message::newInstance()
                ->setSubject("Demande de modification de l'annonce ")
                ->setFrom('arthurdebarbanson@gmail.com')
                ->setTo('recipient@example.com')
                ->setBody(
                    $this->renderView(
                        'Emails/ModificationAnnonce.html.twig', [
                            'message' => $data['Message']
                        ]
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $offre->setEtatOffre('En attente de modification');

            $em->persist($offre);
            $em->flush();

            $this->addFlash('info', "L'email à été envoyé !");
            return $this->redirectToRoute('acceuil_responsable');
        } else {
            $errors_modif = $formModifier->getErrors();
        }

        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $data2 = $formulaire->getData();

            // en attente serveur smtp
//            $this->get('site.mailer')->sendMessage('');

            $message = \Swift_Message::newInstance()
                ->setSubject('Refuse de validation')
                ->setFrom('arthurdebarbanson@gmail.com')
                ->setTo('recipient@example.com')
                ->setBody(
                    $this->renderView(
                        'Emails/refusAnnonce.html.twig', [
                            'message' => $data2['Message']
                        ]
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            $em->remove($offre);
            $em->flush();

            $this->addFlash('info', "L'email à été envoyé !");
            $this->addFlash('info', "L'annonce a été suprimer !");
            return $this->redirectToRoute('acceuil_responsable');

        } else {
            $errors_refus = $formulaire->getErrors();
        }

        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig',
            [
                'offre' => $offre,
                'form_refus' => $formulaire->createView(),
                'form_modif' => $formModifier->createView(),
                'form' => $form->createView(),
                'error_refus' => $errors_refus,
                'error_modif' => $errors_modif,
                'errorEtudiant' => '',
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

    public function ajouterTripletteAction(Request $request)
    {

        $repositoryTuteur = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Personne');

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
                $em->flush();
                $this->addFlash('success', "Le tuteur a été assigné a cet étudiant");
                return $this->redirect($this->generateUrl('acceuil_responsable'));
            }

            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $tuteur = new Personne();
                $tuteur->setSexe($data['Civilite']);
                $tuteur->setPrenom($data['Prenom']);
                $tuteur->setNom($data['Nom']);
                $tuteur->setMail($data['Email']);
                $tuteur->setTelephone($data['Tel']);
                $tuteur->setisTuteur(1);
                $em->persist($tuteur);
                $em->flush();
                $this->addFlash('success', "Le tuteur a été créé");

                $form = $this->createForm(AjoutTuteur::class);
                $tuteurs = $repositoryTuteur->findBy(["isTuteur" => "1"]);
                return $this->render(
                    'SiteBundle:Responsable:ajoutTueur.html.twig',
                    ['form' => $form->createView(), 'assign' => $assign->createView(), 'tuteurs' => $tuteurs]
                );

            }
        }

        return $this->render(
            'SiteBundle:Responsable:ajoutTueur.html.twig',
            ['form' => $form->createView(), 'assign' => $assign->createView(), 'tuteurs' => $tuteurs]
        );
    }

    public function validerEtatEtudiantAction(Request $request)
    {

        $idEtudiant = $request->get('EtudiantId');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');

        $etudiant = $repository->find($idEtudiant);

        $em = $this->getDoctrine()->getManager();
        $etudiant->getDossierInscription()->setEtatDossier('3');

        $em->persist($etudiant);
        $em->flush();

        return $this->redirectToRoute('acceuil_responsable');
    }

    public function emailAction(Request $request){

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EmailEtapeInscription');
        $listeEmails=$repository->find(1);

        $emailEtape=new EmailEtapeInscription();
        $emailEtape->setEtape1($listeEmails->getEtape1());
        $emailEtape->setEtape2($listeEmails->getEtape2());
        $emailEtape->setEtape3($listeEmails->getEtape3());
        $emailEtape->setEtape4($listeEmails->getEtape4());
        $emailEtape->setEtape5($listeEmails->getEtape5());
        $emailEtape->setEtape6($listeEmails->getEtape6());

        $emailform=$this->createForm(EmailEtapeInscriptionType::class, $listeEmails);

        $emailform->handleRequest($request);
        if($emailform->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($emailEtape);
            $em->flush();
            $this->addFlash('info', "Les modifications on été enregistrer");

        }
        return $this->render('SiteBundle:Responsable:gestionEmail.html.twig', [
            'form_email' => $emailform->createView(),
        ]);

    }


}
