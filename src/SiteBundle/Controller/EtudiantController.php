<?php

namespace SiteBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use SiteBundle\Entity\Adresse;
use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\EtudiantOffre;
use SiteBundle\Forms\Types\AjoutPdfEtu;
use SiteBundle\Forms\Types\FichePreInscription;
use SiteBundle\Forms\Types\ModifierEtudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtudiantController extends Controller
{
    public function accueilAction(Request $request)
    {
        $error = '';
        $repositoryEtudiant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
        $repositoryOffre = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Offre');
        $repositoryEntreprise = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Entreprise');

        $etudiant = $repositoryEtudiant->find($this->getUser()->getIdEtudiant());
        $offre  = $repositoryOffre->findBy(['Etudiant' => $this->getUser()->getIdEtudiant()]);
        if(!empty($offre[0])){
            $entreprise = $repositoryEntreprise->find($offre[0]->getEntreprise()->getId());
        }else{$entreprise = null;}


        $form = $this->createForm(AjoutPdfEtu::class);
        $formPreInscription = $this->createForm(FichePreInscription::class);
        $formModificationEtudiant = $this->createForm(ModifierEtudiant::class);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            $formModificationEtudiant->handleRequest($request);
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
            if ($formModificationEtudiant->isValid()) {
                $data = $formModificationEtudiant->getData();
                $em = $this->getDoctrine()->getManager();

                $etudiant = $repositoryEtudiant->find($this->getUser()->getIdEtudiant());

                $etudiant->getDossierInscription()->setEtatDossier("1");

                $etudiant->getLaPersone()->setNom($data["Nom"]);
                $etudiant->getLaPersone()->setPrenom($data["Prenom"]);
                $etudiant->getLaPersone()->setTelephone($data["Telephone"]);
                $etudiant->getLaPersone()->setSexe($data["Civilite"]);
                $etudiant->getLaPersone()->setMail($data["Email"]);
                $etudiant->getLaPersone()->setSexe($data["Civilite"]);


                $etudiant->setNationalite($data["Nationalite"]);
                $etudiant->setVilleNaissance($data["VilleNaissance"]);
                $etudiant->setNumeroDossierCandidature($data["NumeroCiel2"]);
                $etudiant->setDateNaissance($data["DateNaissance"]);

                if($etudiant->getLaPersone()->getAdresse() == null){

                    $Adresse = new Adresse();
                    $Adresse->setCodePostal($data["CodePostal"]);
                    $Adresse->setAdresse($data["Adresse"]);
                    $Adresse->setCommune($data["Commune"]);
                    $Adresse->setPays("France");

                    $etudiant->getLaPersone()->setAdresse($Adresse);

                }else{

                    $repositoryAdresse = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('SiteBundle:Adresse');

                    $Adresse = $repositoryAdresse->find($etudiant->getLaPersone()->getAdresse());
                    $Adresse->setCodePostal($data["CodePostal"]);
                    $Adresse->setAdresse($data["Adresse"]);
                    $Adresse->setCommune($data["Commune"]);
                    $Adresse->setPays("France");
                    $etudiant->getLaPersone()->setAdresse($Adresse);
                }

                $em->persist($etudiant);

                try {
                    $em->flush();
                    $this->addFlash('success', "l'étudiant à été modifier !");
                } catch (UniqueConstraintViolationException $exception) {
                    $this->addFlash('error', $data['Email'] . " est déjà associée à un autre compte.");
                }

            }

        }

        return $this->render(
            'SiteBundle:Etudiant:accueil_etudiant.html.twig', [
                'form2' => $form->createView(),
                'error' => $error,
                'etudiant' => $etudiant,
                'formPreInscription' => $formPreInscription->createView(),
                'entreprise' => $entreprise,
                'formModificationEtudiant' => $formModificationEtudiant->createView()
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

    public function listeOffrePostulerAction()
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

    public function accepterAnnonceAction($annonceId)

    {   $em = $this->getDoctrine()->getManager();
        $repositoryEtudiant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
        $repositoryOffre = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Offre');
        $repositoryEtuOffre = $this->getDoctrine()->getManager()->getRepository('SiteBundle:EtudiantOffre');
        $etudiant = $repositoryEtudiant->find($this->getUser()->getIdEtudiant());
        $offre = $repositoryOffre->find($annonceId);
        $offre->setEtudiant($etudiant);
        $offre->setEtatOffre("Pourvue");
        $etudiant->getDossierInscription()->setEtatDossier("2");
        $em->flush();
        $offres = $repositoryEtuOffre->findBy(array("Offre"=>$offre));
        foreach ($offres as $offreetu) {

            if($offreetu->getEtudiant()!=$etudiant){
                $offreetu->setEtat("Refuser");
            }else {

                $offreetu->setEtat("Accepter");
            }
            $em->flush();
        }

        return $this->redirect($this->generateUrl('site_accueilEtudiant'));
    }
}
