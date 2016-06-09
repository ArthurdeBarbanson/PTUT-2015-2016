<?php

namespace SiteBundle\Controller;

use DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use SiteBundle\Entity\Dirigeant;
use SiteBundle\Entity\Entreprise;
use SiteBundle\Entity\MAP;
use SiteBundle\Entity\Offre;
use SiteBundle\Entity\Personne;
use SiteBundle\Entity\User;
use SiteBundle\Forms\Types\AdresseType;
use SiteBundle\Forms\Types\CreateAnnonce;
use SiteBundle\Forms\Types\CreateMap;
use SiteBundle\Forms\Types\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntrepriseController extends Controller
{


    public function accueilAction()
    {

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Entreprise');

        $entreprise = $this->getUser()->getIdEntreprise();

        $repositoryOffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offresValidations = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "En attente de validation"));
        $offres = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "En ligne"));
        $offresPourvues = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "Pourvue"));
        $offresModification = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "En attente de modification"));
        $repositoryPostulant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:EtudiantOffre');
        $result = array();
        foreach ($offres as $offre) {
            $id = $offre->getId();

            $postulantOffres = array($id => $repositoryPostulant->findBy(array("Offre" => $offre)));
            $result = array_merge($postulantOffres, $result);
        }
        return $this->render(
            'SiteBundle:Entreprise:accueil_entreprise.html.twig',
            ['offresLigne' => $offres, 'offresValidations' => $offresValidations, 'offresPourvues' => $offresPourvues, 'postulantOffres' => $result ,'offresModification' => $offresModification]
        );
    }

    public function ajoutAnnonceAction(Request $request)
    {
        { $em= $this
            ->getDoctrine()
            ->getManager();

            $modal = false;
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:Entreprise');

            $entreprise = $this->getUser()->getIdEntreprise();
            $promos = $em->getRepository('SiteBundle:Session')->findAll();

            $form = $this->createForm(CreateAnnonce::class , $promos);
            $form2 = $this->createForm(CreateMap::class);
            $em = $this->getDoctrine()->getManager();


            $repositoryMap = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:MAP');

            $maps = $repositoryMap->findBy(array("Entreprise" => $entreprise));


            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->get('cancel')->isClicked()) {
                    return $this->redirect($this->generateUrl('site_accueilEntreprise'));
                }

                if ($form->isValid()) {
                    $data = $form->getData();

                    if ($data['pdf'] != "" or $data['Sujet'] != "") {

                        $dateDepot = new DateTime();
                        $dateDepot->format('Y-m-d H');
                        $map = $repositoryMap->find($request->request->get('map'));

                        $annonce = new Offre;
                        $annonce->setDateDepot($dateDepot);
                        $annonce->setEtatOffre("En attente de validation");
                        $annonce->setSujet($data['Sujet']);
                        $annonce->setTitre($data['Titre']);
                        $annonce->setLicenceConcerne(($data['Lpconcerne']));
                        $annonce->setEntreprise($entreprise);
                        $annonce->setMAP($map);
                        $annonce->setSession($data['promo']);
                        $date = new \DateTime();
                        $annee = $date->format('Y');
                        if ($data['pdf'] != ""){
                        $dir = 'uploads/offre/' . $annee;
                        $file = $form['pdf']->getData();
                        $extension = $file->guessExtension();
                        if ($extension == 'pdf' || $extension == 'doc'|| $extension == 'docx' ) {

                            $uniqId = uniqid();
                            $file->move($dir, $data['Titre'] . '_' . $uniqId . '.' . $extension);

                            $final_url = $dir . '/' . $data['Titre'] . '_' . $uniqId . '.' . $extension;

                        $annonce->setDocument($final_url);
                        }}

                        $em->persist($annonce);
                        $em->flush();
                        $this->addFlash('info', "L'annonce a été mis en attente de Validation.");
                        return $this->redirect($this->generateUrl('site_accueilEntreprise'));
                    } else {
                        $this->addFlash('error', "Vous devez renseignez dans le cadre prevue a cette effet le sujet de l'offre ou bien joindre un Pdf/doc comprenant ces informations..");
                    }
                }
                $form2->handleRequest($request);
                if ($form2->get('submit')->isClicked()) {
                    if ($form2->isValid()) {
                        $data = $form2->getData();
                        $personne = new Personne();
                        $map = new MAP();

                        $repositoryAdresse = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('SiteBundle:Adresse');

                        $adresse = $repositoryAdresse->find(1);
                        $personne->setSexe($data['Civilite']);
                        $personne->setPrenom($data['Prenom']);
                        $personne->setNom($data['Nom']);
                        $personne->setMail($data['Email']);
                        $personne->setTelephone($data['Tel']);
                        $personne->setisTuteur(1);
                        $personne->setAdresse($adresse);
                        $map->setDateNaissance($data['DateN']);
                        $map->setLaPersone($personne);
                        $map->setFonction($data['Fonction']);
                        $map->setAEteFormationMaitreApprentissage($data['DejaFormerMaj']);
                        $map->setEntreprise($entreprise);
                        $map->setAEteMaitreApprentissage($data['DejaMaj']);

                        $em->persist($personne);
                        $em->persist($map);

                        $em->flush();
                        return $this->redirectToRoute('site_ajoutAnnonce');
                    } else {
                        $modal = true;
                        return $this->render(
                            'SiteBundle:Default:ajoutAnnonce.html.twig',
                            ['form' => $form->createView(), 'form2' => $form2->createView(), 'maps' => $maps, 'bool' => $modal]
                        );

                    }
                }
            }
            return $this->render(
                'SiteBundle:Default:ajoutAnnonce.html.twig',
                ['form' => $form->createView(), 'form2' => $form2->createView(), 'maps' => $maps, 'bool' => $modal]
            );
        }
    }

    public function edditAnnonceAction(Request $request)
    {
        {
            $modal = false;
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:Entreprise');

            $entreprise = $repository->find($this->getUser()->getIdEntreprise());
            $idAnnonce = $request->get('annonceId');

            $repositoryOffre = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:Offre');

            $annonce = $repositoryOffre->find($idAnnonce);

            $form2 = $this->createForm(CreateMap::class);
            $em = $this->getDoctrine()->getManager();

            $repositoryMap = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:MAP');

            $maps = $repositoryMap->findBy(array("Entreprise" => $entreprise));
            $form = $this->createFormBuilder()
                ->add('Titre', TextType::class, array(
                    'data' => $annonce->getTitre(),
                    'constraints' => [new NotBlank(), new Length(['min' => 3])
                    ]
                ))
                ->add('licenceConcerne', ChoiceType::class, array(
                    'label' => 'Lp concerné',
                    'choices' => array('IEM' => 'LP IEM', 'METINET' => 'LP METINET'),
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
                    'data' => $annonce->getLicenceConcerne()
                ))
                ->add('Sujet', TextareaType::class, array(
                    'label' => 'Sujet (Description de la mission - Technologie)',
                    'data' => $annonce->getSujet(),
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 50])
                    ]
                ))
                ->add('submit', SubmitType::class, [
                    'label' => 'Poster',
                    'attr' => ['class' => 'btn-primary margTop10'],

                ])
                ->add('cancel', SubmitType::class, array(
                    'label' => 'Annulez',
                    'attr' => ['formnovalidate' => 'formnovalidate', 'class' => 'btn-default margTop10'],

                ))
                ->getForm();

            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->get('cancel')->isClicked()) {

                    return $this->redirect($this->generateUrl('site_accueilEntreprise'));
                }
                if ($form->isValid()) {
                    $data = $form->getData();

                    $map = $repositoryMap->find($request->get('map'));

                    $annonce->setEtatOffre("En attente de validation");
                    $annonce->setSujet($data['Sujet']);
                    $annonce->setTitre($data['Titre']);
                    $annonce->setLicenceConcerne(($data['licenceConcerne']));
                    $annonce->setMAP($map);

                    $em->flush();
                    $this->addFlash('info', "L'annonce a été mise a jour.");

                    return $this->redirect($this->generateUrl('site_accueilEntreprise'));
                }

                $form2->handleRequest($request);

                if ($form2->isValid()) {
                    var_dump("form 2");
                    $data = $form2->getData();
                    $personne = new Personne();
                    $map = new MAP();

                    $personne->setSexe($data['Civilite']);
                    $personne->setPrenom($data['Prenom']);
                    $personne->setNom($data['Nom']);
                    $personne->setMail($data['Email']);
                    $personne->setTelephone($data['Tel']);
                    $map->setDateNaissance($data['DateN']);
                    $map->setLaPersone($personne);
                    $map->setFonction($data['Fonction']);
                    $map->setAEteFormationMaitreApprentissage($data['DejaFormerMaj']);
                    $map->setEntreprise($entreprise);
                    $map->setAEteMaitreApprentissage($data['DejaMaj']);

                    $em->persist($personne);
                    $em->persist($map);

                    $em->flush();
                    return $this->redirectToRoute('site_ajoutAnnonce');
                } else {
                    var_dump("Réaffichage modal");
                    $modal = true;
                    return $this->render(
                        'SiteBundle:Default:edditAnnonce.html.twig',
                        ['annonce' => $annonce, 'form' => $form->createView(), 'form2' => $form2->createView(), 'maps' => $maps, 'bool' => $modal]
                    );
                }
            }

            return $this->render(
                'SiteBundle:Default:edditAnnonce.html.twig',
                ['annonce' => $annonce, 'form' => $form->createView(), 'form2' => $form2->createView(), 'maps' => $maps, 'bool' => $modal]
            );
        }
    }

    public function edditEntrepriseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SiteBundle:Entreprise');
        $repositoryD= $em->getRepository('SiteBundle:Dirigeant');
        $entreprise = $repository->find($this->getUser()->getIdEntreprise());
        $dirigeant = $repositoryD->findBy(array("Entreprise"=>$entreprise->getId()));

        $form = $this->createFormBuilder()
            ->add('raisonSocial', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'data' => $entreprise->getRaisonSocial()
            ])
            ->add('nom', TextType::class,['constraints' => [
                new NotBlank(),
                new Length(['min' => 3])
            ],
                'label' => 'Nom du contact',
                'data' => $entreprise->getNom()
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ],
                'label' => 'Prenom du contact',
                'data' => $entreprise->getPrenom()
            ])
            ->add('mail', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'strict' => false,
                        'checkMX' => true,
                        'checkHost' => true
                    ])
                ],
                'label' => 'E-mail du contact',
                'data' => $entreprise->getMail()
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone du contact',
                'data' => $entreprise->getTelephone(),
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10, 'max' => 12])]
            ])

            ->add('siteWeb', UrlType::class, array(
                'required' => false,
                'data' => $entreprise->getSiteWeb()
            ))
            ->add('nombrePersonne', IntegerType::class, ['data' => $entreprise->getNombrePersonne()])
            ->add('siret', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'data' => $entreprise->getSiret()
            ])
            ->add('aPE', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'data' => $entreprise->getAPE()
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'data' => $entreprise->getDescription()
            ])
            ->add('Adresse', AdresseType::class, array('label' => 'Localisation',
                'data'=>$entreprise->getAdresse()   ))

            ->add('CiviliteD',ChoiceType::class, array(
                'choices' => array(' Monsieur ' => 'M', 'Madame ' => 'F'),
                'label' => 'Civilité',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'data' => $dirigeant[0]->getLaPersone()->getSexe()
            ))
            ->add('FunctionD',ChoiceType::class, array(
                'choices' => array(' Dirigeant ' => 'Dirigeant', 'DRH ' => 'DRH'),
                'label' => 'Fonction',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'data' => $dirigeant[0]->getFonction()
            ))
            ->add('PrenomD', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ],
                'label' => 'Prenom du '.$dirigeant[0]->getFonction(),
                'data' => $dirigeant[0]->getLaPersone()->getPrenom()
            ])

            ->add('NomD', TextType::class,['constraints' => [
                new NotBlank(),
                new Length(['min' => 3])
            ],
                'label' => 'Nom du '.$dirigeant[0]->getFonction(),
                'data' => $dirigeant[0]->getLaPersone()->getNom()
            ])

            ->add('MailD', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'strict' => false,
                        'checkMX' => true,
                        'checkHost' => true
                    ])
                                    ],
                'label' => 'E-mail du '.$dirigeant[0]->getFonction(),
                'data' => $dirigeant[0]->getLaPersone()->getMail()
            ])

            ->add('submit', SubmitType::class, ['label' => "Modifier",
                'attr' => ['class' => 'btn-primary']])
            ->add('cancel', SubmitType::class, array(
                'label' => 'Annulez',
                'attr' => ['formnovalidate' => 'formnovalidate', 'class' => 'btn-default'],

            ))
            ->getForm();
        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->get('cancel')->isClicked()) {

                return $this->redirect($this->generateUrl('site_accueilEntreprise'));
            }
            if ($form->isValid()) {
                $data = $form->getData();

                $entreprise->setRaisonSocial($data["raisonSocial"]);
                $entreprise->setPrenom($data["prenom"]);
                $entreprise->setAdresse($data["Adresse"]);
                $entreprise->setAPE($data["aPE"]);
                $entreprise->setNom($data["nom"]);
                $entreprise->setTelephone($data["telephone"]);
                $entreprise->setSiteWeb($data["siteWeb"]);
                $entreprise->setNombrePersonne($data["nombrePersonne"]);
                $entreprise->setSiret($data["siret"]);
                $entreprise->setDescription($data["description"]);
                $entreprise->setMail($data["mail"]);
                $dirigeant[0]->setFonction($data["FunctionD"]);
                $dirigeant[0]->getLaPersone()->setMail($data["MailD"]);
                $dirigeant[0]->getLaPersone()->setSexe($data["CiviliteD"]);
                $dirigeant[0]->getLaPersone()->setNom($data["NomD"]);
                $dirigeant[0]->getLaPersone()->setPrenom($data["PrenomD"]);


                $em->flush();
                $this->addFlash('info', "L'entreprise a été mise a jour.");

                return $this->redirect($this->generateUrl('site_accueilEntreprise'));
            }
        }
        return $this->render(
            'SiteBundle:Entreprise:modification_entreprise.html.twig',
            ['form' => $form->createView()]
        );
    }

    public function inscriptionAction(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //entreprise
            $entreprise->setAPE($data['aPE']);
            $entreprise->setDescription($data['description']);
            $entreprise->setMail($data['mail']);
            $entreprise->setNom($data['nom']);
            $entreprise->setNombrePersonne($data['nombrePersonne']);
            $entreprise->setPrenom($data['prenom']);
            $entreprise->setRaisonSocial($data['raisonSocial']);
            $entreprise->setSiret($data['siret']);
            $entreprise->setDescription($data['description']);
            $entreprise->setSiteWeb($data['siteWeb']);
            $entreprise->setTelephone($data['telephone']);
            $entreprise->setAdresse($data['Adresse']);


            //personne
            $personne = new Personne();
            $personne->setNom($data['NomD']);
            $personne->setSexe($data['CiviliteD']);
            $personne->setPrenom($data['PrenomD']);
            $personne->setMail($data['MailD']);

            //dirigeant
            $dirigeant = new Dirigeant();
            $dirigeant->setEntreprise($entreprise);
            $dirigeant->setFonction($data['FunctionD']);
            $dirigeant->setLaPersone($personne);
            $dirigeant->setEntreprise($entreprise);
            
            $em = $this->getDoctrine()->getManager();
            $user = new User();
            $user->setIdEntreprise($entreprise);
            $user->setRoles(array('ROLE_ENTREPRISE'));
            $user->setUsername($entreprise->getMail());

            //set password
            $randomPassword = $this->randomPassword();
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $randomPassword);
            $user->setPassword($encoded);
            $em->persist($user);
            $em->persist($dirigeant);


            try {
                $em->flush();
                $this->get('site.mailer.entreprise')->inscriptionEntreprise($user->getIdEntreprise()->getMail(), $randomPassword);
                $this->addFlash('success', 'Inscription terminé avec succès, vous allez recevoir un mail avec vos identifiants.');
                return $this->redirect($this->generateUrl('site_homepage'));
            } catch (UniqueConstraintViolationException $exception) {
                $this->addFlash('error', "Cette adresse est déjà utilisé par un autre utilisateur.");
            } catch (Exception $exception) {
                $this->addFlash('error', "Un erreur s'est produite, veuillez réessayer plus tard.");
            }
        }

        return $this->render(
            'SiteBundle:Entreprise:inscription_entreprise.html.twig'
            , ['form' => $form->createView()]
        );
    }

    public function detailsPostulantsAction(Request $request)
    {

        $postulantId = $request->get('postulantId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EtudiantOffre');

        $offre = $repository->find($postulantId);
        //si l'annonce n'es pas trouvé
        if (null === $offre) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }

        return $this->render(
            'SiteBundle:Entreprise:detailsPostulants.html.twig', ['postulant' => $offre]

        );

    }

    public function detailsEtudiantAction(Request $request)
    {

        $offreId = $request->get('offreId');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offre = $repository->find($offreId);
        //si l'annonce n'es pas trouvé
        if (null === $offre) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }

        return $this->render(
            'SiteBundle:Entreprise:detailsEtudiant.html.twig', ['offre' => $offre]

        );

    }

    public function impressionPostulantsAction(Request $request)
    {
        $postulantId = $request->get('postulantId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EtudiantOffre');

        $offre = $repository->find($postulantId);
        //si l'annonce n'es pas trouvé
        if (null === $offre) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }


        $html = $this->renderView(
            'SiteBundle:Entreprise:impressionPostulants.html.twig', ['postulant' => $offre]
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Annonce.pdf"'
            )
        );
    }

    public function supprAnnonceAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $offreId = $request->get('annonceId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offre = $repository->find($offreId);

        $repositoryEtuoffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EtudiantOffre');
        $etuoffres = $repositoryEtuoffre->findBy(array("Offre" => $offre));

        foreach ($etuoffres as $etuoffre) {
            $em->remove($etuoffre);
        }
        $em->flush();
        $em->remove($offre);
        $em->flush();
        return $this->redirect($this->generateUrl('site_accueilEntreprise'));

    }

    public function accepterPostulantsAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postulantId = $request->get('postulantId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EtudiantOffre');

        $offre = $repository->find($postulantId);

        $offre->setEtat("Attente Etudiant");
        $em->flush();
        return $this->redirect($this->generateUrl('site_accueilEntreprise'));
    }

    public function refusPostulantsAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postulantId = $request->get('postulantId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EtudiantOffre');

        $offre = $repository->find($postulantId);

        $offre->setEtat("Refuser");
        $em->flush();
        return $this->redirect($this->generateUrl('site_accueilEntreprise'));

    }

    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
