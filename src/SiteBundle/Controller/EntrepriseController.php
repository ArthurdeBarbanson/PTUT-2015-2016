<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\Entreprise;
use SiteBundle\Entity\Offre;
use SiteBundle\Entity\MAP;
use SiteBundle\Entity\Personne;
use SiteBundle\Forms\Types\EdditAnnonce;
use SiteBundle\Forms\Types\CreateAnnonce;
use SiteBundle\Forms\Types\CreateMap;
use SiteBundle\Forms\Types\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
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

        $entreprise = $repository->find($this->getUser()->getIdEntreprise());

        $repositoryOffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offresValidations = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "En attente de validation"));
        $offres = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "En ligne"));
        $offresPourvues = $repositoryOffre->findBy(array("Entreprise" => $entreprise, "etatOffre" => "Pourvue"));

        $repositoryPostulant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:EtudiantOffre');
        $result = array();
        foreach ($offres as $offre) {
            $id = $offre->getId();

            $postulantOffres = array($id => $repositoryPostulant->findBy(array("Offre" => $offre)));
            $result = array_merge($postulantOffres, $result);
        }
        return $this->render(
            'SiteBundle:Entreprise:accueil_entreprise.html.twig',
            ['offresLigne' => $offres, 'offresValidations' => $offresValidations, 'offresPourvues' => $offresPourvues, 'postulantOffres' => $result]
        );
    }

    public function ajoutAnnonceAction(Request $request)
    {
        {
            $modal = false;
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:Entreprise');

            $entreprise = $repository->find($this->getUser()->getIdEntreprise());

            $form = $this->createForm(CreateAnnonce::class);
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

                    $em->persist($annonce);
                    $em->flush();
                    $this->addFlash('info', "L'annonce a été mis en attente de Validation.");

                    return $this->redirect($this->generateUrl('site_accueilEntreprise'));
                }
                $form2->handleRequest($request);
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
                ->add('Sujet', TextAreaType::class, array(
                    'label' => 'Sujet (Description de la mission - Technologie)',
                    'data' => $annonce->getSujet(),
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 50])
                    ]
                ))
                ->add('submit', SubmitType::class, [
                    'label' => 'Poster',
                    'attr' => ['class' => 'btn-primary btn-lg  col-lg-1 col-lg-offset-4', 'style' => "margin-top:20px"],

                ])
                ->add('cancel', SubmitType::class, array(
                    'label' => 'Annulez',
                    'attr' => ['formnovalidate' => 'formnovalidate', 'class' => 'btn-default btn-lg col-lg-1 col-lg-offset-1', 'style' => "margin-top:20px"],

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

    public function inscriptionAction(Request $request)
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            $this->addFlash('success', 'Inscription terminé avec succès !');

            return $this->redirect($this->generateUrl('site_homepage'));
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
}
