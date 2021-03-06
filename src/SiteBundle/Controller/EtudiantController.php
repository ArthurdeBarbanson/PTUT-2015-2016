<?php

namespace SiteBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use SiteBundle\Entity\Adresse;
use SiteBundle\Entity\BacOuEquivalent;
use SiteBundle\Entity\DernierDiplomeObtenu;
use SiteBundle\Entity\DernierEtablissementFrequente;
use SiteBundle\Entity\Etudiant;
use SiteBundle\Entity\EtudiantOffre;
use SiteBundle\Entity\InscriptionAutreEtablissement;
use SiteBundle\Entity\PremiereInscription;
use SiteBundle\Forms\Types\AjoutPdfEtu;
use SiteBundle\Forms\Types\ChoixTypeContrat;
use SiteBundle\Forms\Types\FichePreInscription;
use SiteBundle\Forms\Types\ModifierEtudiant;
use SiteBundle\Forms\Types\MotDePasseEtudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtudiantController extends Controller
{
    public function accueilAction(Request $request)
    {
        $error = '';
        $repositoryEtudiant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
        $repositoryOffre = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Offre');
        $repositoryEntreprise = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Entreprise');
        $repositoryDirigeant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Dirigeant');

        $etudiant = $repositoryEtudiant->find($this->getUser()->getIdEtudiant());
        $offre  = $repositoryOffre->findBy(['Etudiant' => $this->getUser()->getIdEtudiant()]);

        if(!empty($offre[0])){
            $entreprise = $repositoryEntreprise->find($offre[0]->getEntreprise()->getId());
            $dirigeants = $repositoryDirigeant->findBy(array("Entreprise"=>$entreprise));
        }else{$entreprise = null;
                $dirigeants = null;
            $offre[0] = null;
        }

        $form = $this->createForm(AjoutPdfEtu::class);
        $formPreInscription = $this->createForm(FichePreInscription::class);
        $formModificationEtudiant = $this->createForm(ModifierEtudiant::class);
        $formTypeContrat = $this->createForm(ChoixTypeContrat::class);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            $formModificationEtudiant->handleRequest($request);
            $formPreInscription->handleRequest($request);
            $formTypeContrat->handleRequest($request);
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
            if ($formModificationEtudiant->isValid() || $formModificationEtudiant->isSubmitted()) {
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
                $etudiant->setTypeLicence($data["Lpconcerne"]);

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
                    $this->addFlash('success', "L'étudiant à été modifier !");
                } catch (UniqueConstraintViolationException $exception) {
                    $this->addFlash('error', $data['Email'] . " est déjà associée à un autre compte.");
                }

            }


            if ($formPreInscription->isValid() || $formPreInscription->isSubmitted()) {
                $data = $formPreInscription->getData();
                $em = $this->getDoctrine()->getManager();

                $msg  = 'Je pense que les informations liées au';
                $msgError = 'Je pense que les informations liées au';

                $BacOuEquivalent = new BacOuEquivalent();
                $BacOuEquivalent->setDossierInscription($etudiant->getDossierInscription());
                $BacOuEquivalent->setIntitule($data["Intitule"]);
                $BacOuEquivalent->setMention($data["Mention"]);
                $BacOuEquivalent->setTypeEtablissementObtention($data["Type"]);
                $BacOuEquivalent->setDepartementEtablissementObtention($data["Departement"]);
                $BacOuEquivalent->setNomEtablissementObtention($data["Nom"]);


                $em->persist($BacOuEquivalent);
                try {
                    $em->flush();
                    $msg .= " Bac ou équivalent ";
                } catch (UniqueConstraintViolationException $exception) {
                    $msgError .="  Bac ou équivalent";
                }

                $DernierEtablissementFrequente = new DernierEtablissementFrequente();
                $DernierEtablissementFrequente->setDossierInscription($etudiant->getDossierInscription());
                $DernierEtablissementFrequente->setNom($data["NomDernier"]);
                $DernierEtablissementFrequente->setDepartement($data["DepartementDernier"]);
                $DernierEtablissementFrequente->setAnnee($data["AnneDernier"]);
                $DernierEtablissementFrequente->setType($data["TypeDernier"]);
                $DernierEtablissementFrequente->setEstLyon1($data["isLyon"]);
                $DernierEtablissementFrequente->setEstTransfert($data["isTransfert"]);

                $em->persist($DernierEtablissementFrequente);
                try {
                    $em->flush();
                    $msg .= ", Dernier Etablissement Frequente  ";
                } catch (UniqueConstraintViolationException $exception) {
                    $msgError .=" ,Dernier Etablissement Frequente  ";
                }

                $DernierDiplomeObtenu = new DernierDiplomeObtenu();
                $DernierDiplomeObtenu->setDossierInscription($etudiant->getDossierInscription());
                $DernierDiplomeObtenu->setEtablissement($data["EtablissementDernierDiplome"]);
                $DernierDiplomeObtenu->setDepartement($data["DerpartementDernierDiplome"]);
                $DernierDiplomeObtenu->setAnnee($data["AnneeDernierDiplome"]);
                $DernierDiplomeObtenu->setLeDiplomeObtenue($data["IntituleDernierDiplome"]);

                $em->persist($DernierDiplomeObtenu);
                try {
                    $em->flush();
                    $msg .= ", Dernier Diplome Obtenu ";
                } catch (UniqueConstraintViolationException $exception) {
                    $msgError .=", Dernier Diplome Obtenu";
                }

                $InscriptionAutreEtablissement = new InscriptionAutreEtablissement();
                $InscriptionAutreEtablissement->setDossierInscription($etudiant->getDossierInscription());
                $InscriptionAutreEtablissement->setDepartmentEtablissement($data["DepartementAutreEtablissement"]);
                $InscriptionAutreEtablissement->setNomEtablissement($data["NomAutreEtablissement"]);
                $InscriptionAutreEtablissement->setTypeEtablissement($data["TypeAutreEtablissement"]);
                $InscriptionAutreEtablissement->setAnneeEtablissement($data["AnneeAutreEtablissement"]);
                $InscriptionAutreEtablissement->setCodeEtablissement($data["CodeAutreEtablissement"]);
                $InscriptionAutreEtablissement->setEstInscrit($data["isInscrit"]);
                $InscriptionAutreEtablissement->setEstInscriptionMaintenu($data["isInscriptionMainteanue"]);

                $em->persist($InscriptionAutreEtablissement);
                try {
                    $em->flush();
                    $msg .= ",Inscription Autre Etablissement ";
                } catch (UniqueConstraintViolationException $exception) {
                    $msgError .=",Inscription Autre Etablissement ";
                }

                $PremiereInscription = new  PremiereInscription();
                $PremiereInscription->setDossierInscription($etudiant->getDossierInscription());
                $PremiereInscription->setAnneeInscriptionLyon1($data["AnneePremiereInscription"]);
                $PremiereInscription->setAnneeUniversiteFrancaise($data["AnneeUniversitePremiereInscription"]);
                $PremiereInscription->setNomUniversite($data["NomPremiereInscription"]);
                $PremiereInscription->setAnneeEnseignementSuperieur($data["AnneeSUPPremiereInscription"]);

                $em->persist($PremiereInscription);

                try {
                    $em->flush();
                    $msg .= ",Premiere Inscription ";
                } catch (UniqueConstraintViolationException $exception) {
                    $msgError .=" ,Premiere Inscription ";
                }

                if( $msg != ''){
                    $this->addFlash('success', $msg . ' ont été enregistré. ');
                }
                if( $msgError != ''){
                    $this->addFlash('error', $msgError . ' n ont pas été enregistré.');
                }

            }
            if ($formTypeContrat->isValid()) {
                $data = $formTypeContrat->getData();
                $em = $this->getDoctrine()->getManager();
                $offre[0]->setTypeContrat($data["typeContrat"]);
                $em->persist($offre[0]);
                try {
                    $em->flush();
                    $this->addFlash('success', "Je pense que ça a marché");
                } catch (UniqueConstraintViolationException $exception) {
                    $this->addFlash('error', "Je pense pas que ça soit bon");
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
                'dirigeants' => $dirigeants,
                'formModificationEtudiant' => $formModificationEtudiant->createView(),
                'offre' => $offre[0],
                'formTypeContrat' => $formTypeContrat->createView(),
            ]
        );
    }

    public function modificationMotPasseAction(Request $request)
    {
        $form = $this->createForm(MotDePasseEtudiant::class);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
                $data = $form->getData();
                $verification = $data["verif_mdp"];
                $mdp = $data['password'];
                $encoder = $this->get('security.password_encoder');
                $em = $this->getDoctrine()->getManager();
                if ($encoder->isPasswordValid($this->getUser(), $verification)) {
                    $user = $this->getUser();
                    $user->setPassword($encoder->encodePassword($user, $mdp));
                    $em->persist($user);
                    try {
                        $em->flush();
                        $this->addFlash('success', "Mot de passe modifié avec succès.");
                    } catch (Exception $ex) {
                        $this->addFlash('error', "Erreur lors de la modification du mot de passe.");
                    }
                }
            }
        }

        return $this->render(
            'SiteBundle:Etudiant:modification_mot_de_passe.html.twig', ['form' => $form->createView()]
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
        $offres = $repositoryEtuOffre->findBy(array("Etudiant"=>$etudiant));
        foreach ($offres as $etuoffre){

            if($etuoffre->getEtudiant()!=$etudiant){
                if ($etuoffre->getEtat()=="Attente Etudiant"){
                    $message = \Swift_Message::newInstance()
                        ->setSubject("Alternant LP".$offre->getLicenceConcerne())
                        ->setFrom('arthurdebarbanson@gmail.com')
                        ->setTo($offre->getEntreprise()->getMail())
                        ->setBody("Madame, Monsieur " . $offre->getEntreprise()->getNom().". L'etudiant" . $etudiant->getLaPersone()->getNom() . $etudiant->getLaPersone()->getPrenom()
                            . "à finalement refuser votre offre ou bien accepter une autre offre. Votre annonce reste donc en ligne. Cordialement");
                    $this->get('mailer')->send($message);

                }
                $etuoffre->setEtat("Refuser");

                $em->flush();
            }
            $em->flush();
        }
        $message = \Swift_Message::newInstance()
            ->setSubject("Validation Alternant LP".$offre->getLicenceConcerne())
            ->setFrom('arthurdebarbanson@gmail.com')
            ->setTo($offre->getEntreprise()->getMail())
            ->setBody("Madame, Monsieur " . $offre->getEntreprise()->getNom().". J'ai le plaisir de vous annoncez que l'etudiant " . $etudiant->getLaPersone()->getNom() ." ". $etudiant->getLaPersone()->getPrenom()
                . " a egalement validez votre offre. L'etudiant doit maintenant s'inscrire au pret de l'ecole et de formasup. Une fois ces étapes terminées le contrat sera alors mis en place. Cordialement");
        $this->get('mailer')->send($message);

        $message = \Swift_Message::newInstance()
            ->setSubject("[".$offre->getLicenceConcerne()."] Changement Etape " . $etudiant->getLaPersone()->getNom() ." " . $etudiant->getLaPersone()->getPrenom() )
            ->setFrom('arthurdebarbanson@gmail.com')
            ->setTo("iut@yopmail.fr")
            ->setBody("Bonjour, ce message vous est transmis car ". $etudiant->getLaPersone()->getNom() ." ". $etudiant->getLaPersone()->getPrenom() . " a validé l'étape 1 et trouvé une. Cordialement" );
        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('site_accueilEtudiant'));
    }

    public function refuserAnnonceAction($annonceId)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryOffreetu= $this->getDoctrine()->getManager()->getRepository('SiteBundle:EtudiantOffre');
        $offreetu = $repositoryOffreetu->find($annonceId);
        $offreetu->setEtat("Refuser");
        $repositoryEtudiant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
        $etudiant = $repositoryEtudiant->find($this->getUser()->getIdEtudiant());
        $em->flush();
        $message = \Swift_Message::newInstance()
            ->setSubject("Alternant LP".$offreetu->getOffre()->getLicenceConcerne())
            ->setFrom('arthurdebarbanson@gmail.com')
            ->setTo($offreetu->getOffre()->getEntreprise()->getMail())
            ->setBody("Madame, Monsieur " . $offreetu->getOffre()->getEntreprise()->getNom().". L'etudiant" . $etudiant->getLaPersone()->getNom() . $etudiant->getLaPersone()->getPrenom()
                . "à finalement refuser votre offre ou bien accepter une autre offre. Votre annonce reste donc en ligne. Cordialement");
        $this->get('mailer')->send($message);
        return $this->redirect($this->generateUrl('site_listeOffrePostulerEtudiant'));
    }

    public function impressionDossierInsciptionAction(Request $request)
    {
        $dossierID = $request->get('dossierId');
        $repositoryDossier = $this->getDoctrine()->getManager()->getRepository('SiteBundle:DossierInscription');
        $repositoryEtudiant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
        $repositoryPremiereInscription = $this->getDoctrine()->getManager()->getRepository('SiteBundle:PremiereInscription');
        $repositoryBacOuEquivalent = $this->getDoctrine()->getManager()->getRepository('SiteBundle:BacOuEquivalent');
        $repositoryDernierEtablissementFrequente = $this->getDoctrine()->getManager()->getRepository('SiteBundle:DernierEtablissementFrequente');
        $repositoryDernierDiplomeObtenu = $this->getDoctrine()->getManager()->getRepository('SiteBundle:DernierDiplomeObtenu');
        $repositoryInscriptionAutreEtablissement = $this->getDoctrine()->getManager()->getRepository('SiteBundle:InscriptionAutreEtablissement');

        $Dossier = $repositoryDossier->find($dossierID);
        $Etudiant = $repositoryEtudiant->findBy(["DossierInscription"=>$Dossier]);
        $PremiereInscription = $repositoryPremiereInscription->findBy(["DossierInscription"=>$Dossier]);
        $BacOuEquivalent = $repositoryBacOuEquivalent->findBy(["DossierInscription"=>$Dossier]);
        $DernierEtablissementFrequente = $repositoryDernierEtablissementFrequente->findBy(["DossierInscription"=>$Dossier]);
        $DernierDiplomeObtenu = $repositoryDernierDiplomeObtenu->findBy(["DossierInscription"=>$Dossier]);
        $InscriptionAutreEtablissement = $repositoryInscriptionAutreEtablissement->findBy(["DossierInscription"=>$Dossier]);
        //si l'annonce n'es pas trouvé
        if (null === $Dossier) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }


        $html = $this->renderView(
            'SiteBundle:Etudiant:ImpressionDossierInscription.html.twig', [
                'Dossier' =>  $Dossier,
                'Etudiant' =>  $Etudiant[0],
                'PremiereInscription' => $PremiereInscription[0],
                'BacOuEquivalent' => $BacOuEquivalent[0],
                'DernierEtablissementFrequente' => $DernierEtablissementFrequente[0],
                'DernierDiplomeObtenu' => $DernierDiplomeObtenu[0],
                'InscriptionAutreEtablissement' =>  $InscriptionAutreEtablissement[0]
            ]
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Dossier.pdf"'
            )
        );

    }

    public function recapOffreAction(Request $request)
    {
        $repositoryEtudiant = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
        $etudiant = $repositoryEtudiant->find($this->getUser()->getIdEtudiant());
        $offre= $this->getDoctrine()->getManager()->getRepository('SiteBundle:Offre')->findBy(array('Etudiant'=>$etudiant));

        return $this->render(
            'SiteBundle:Etudiant:recapOffre.html.twig', [
                'offre' =>  $offre[0]

            ]
        );
    }
}
