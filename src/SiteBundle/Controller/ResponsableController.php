<?php

namespace SiteBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use SiteBundle\Entity\Adresse;
use SiteBundle\Entity\DossierInscription;
use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\Personne;
use SiteBundle\Entity\User;
use SiteBundle\Forms\Types\AjoutEtudiantImport;
use SiteBundle\Forms\Types\AjoutTuteur;
use SiteBundle\Forms\Types\AssignerTuteur;
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
        $repositoryOffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $repositoryEtudiant = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Etudiant');

        $offres = $repositoryOffre->findAll();
        $etudiants = $repositoryEtudiant->findAll();

        $smtpForm= $this->createForm(SMTPType::class);

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
                //TODO envoie de mail
                /*$message = new \Swift_Message();
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
                $this->get('mailer')->send($message);*/

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

            //dossier
            $dossier = new DossierInscription();
            $dossier->setEtatDossier(0);

            //set etudiant
            $etudiant = new Etudiant();
            $etudiant->setLaPersone($personne);
            $etudiant->setTypeLicence($data['Lpconcerne']);
            $etudiant->setInscription($dossier);
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
                //envoie de mail
                /*$message = new \Swift_Message();
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
                $this->get('mailer')->send($message);*/

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
                        $user->setUsername($etudiant->getLaPersone()->getMail());
                        $encoder = $this->get('security.password_encoder');
                        $encoded = $encoder->encodePassword($user, $randomPassword);
                        $user->setPassword($encoded);
                        $user->setIdEtudiant($etudiant);
                        $user->setRoles(array('ROLE_ETUDIANT'));

                        $em->persist($user);
                        try {
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
                        } catch (Exception $exception) {
                            $this->addFlash('error', "Une erreur s'est produite, veuillez réessayer plus tard.");
                        }
                    }
                }
                if ($nombreUserExistantDeja > 0) {
                    $this->addFlash('success', $nombreUserExistantDeja . "étudiants n'ont pas été enregistrer car ils existaient déjà. Les autres étudiants on été ajoutés avec succès.");
                } else {
                    $this->addFlash('success', "Les étudiants on été ajoutés avec succès.");
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
//        $formModifier = $this->createFormBuilder()
//            ->add('Message', TextareaType::class,[
//                'constraints'=>[
//                    new NotBlank()
//                ]
//            ])
//            ->add('modifier', SubmitType::class, [
//                'label' => 'modifier',
//                'attr' => ['class' => 'btn btn-default  center-block'],
//            ])
//            ->getForm();
        $formModifier = $this->createForm(RefuserAnnonceType::class);
        $formulaire = $this->createForm(ModifierAnnonceType::class);
        $form = $this->createForm(ModifierAnnonceType::class);

            $formModifier->handleRequest($request);
            if ($formModifier->get('submit')->isClicked() && $formModifier->isSubmitted() &&  $formModifier->isValid()) {

                // en attente serveur smtp

//                $message = \Swift_Message::newInstance()
//                    ->setSubject('Refuse de validation ')
//                    ->setFrom('')
//                    ->setTo('recipient@example.com')
//                    ->setBody(
//                        $this->renderView(
//                            'Emails/refusAnnonce.html.twig'
//                        ),
//                        'text/html'
//                    );
//                $this->get('mailer')->send($message);

                $offre->setEtatOffre('En attente de modification');


                $em->persist($offre);
                $em->flush();

                $this->addFlash('info', "L'email à été envoyé !");
            return $this->redirectToRoute('acceuil_responsable');
            }

            $formulaire->handleRequest($request);
            if ($formulaire->get('submit')->isClicked() && $formulaire->isSubmitted() && $formulaire->isValid()) {

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
                $em->remove($offre);
                $em->flush();

                $this->addFlash('info', "L'email à été envoyé !");
                $this->addFlash('info', "L'annonce a été suprimer !");
                return $this->redirectToRoute('acceuil_responsable');

            }

        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig',
            [
                'offre' => $offre,
                'form_refus' => $formulaire->createView(),
                'form_modif' => $formModifier->createView(),
                'form' => $form->createView(),
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
}
