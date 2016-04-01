<?php

namespace SiteBundle\Controller;

use DateTime;
use Proxies\__CG__\SiteBundle\Entity\Entreprise;
use Proxies\__CG__\SiteBundle\Entity\Offre;
use SiteBundle\Entity\MAP;
use SiteBundle\Entity\Personne;
use SiteBundle\Forms\Types\CreateAnnonce;
use SiteBundle\Forms\Types\CreateMap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends Controller
{

    public function ajoutAnnonceAction(Request $request){
        {
            $form = $this->createForm(CreateAnnonce::class);
            $form2 = $this->createForm(CreateMap::class);
            $em = $this->getDoctrine()->getManager() ;

            $repositoryMap = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:MAP');

            $maps = $repositoryMap->find(1);

            if ($request->isMethod('post')) {
               $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();

                    $dateDepot= new DateTime();
                    $dateDepot->format('Y-m-d H');
                    $repository = $this
                       ->getDoctrine()
                       ->getManager()
                       ->getRepository('SiteBundle:Entreprise');

                    $entreprise =$repository->find(2);

                    $annonce= new Offre;
                    $annonce->setDateDepot($dateDepot);
                    $annonce->setEtatOffre("En attende de Validation");
                    $annonce->setSujet($data['Sujet']);
                    $annonce->setTitre($data['Titre']);
                    $annonce->setLicenceConcerne(($data['Lpconcerne']));
                    $annonce->setEntreprise($entreprise);
                    $annonce->setMAP($maps);

                    $em->persist($annonce);
                    $em->flush();
                    $this->addFlash('info', "L'annonce a été mis en attente de Validation.");

                    return $this->redirect('/entreprise/accueil');
               }
                $form2->handleRequest($request);
                if ($form2->isValid()) {
                    $data = $form2->getData();
                    $personne = new Personne();
                    $map = new MAP();
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('SiteBundle:Entreprise');

                    $entreprise =$repository->find(2);
                    $repositoryAdresse = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('SiteBundle:Adresse');

                    $adresse =$repositoryAdresse->find(1);
                    $personne->setSexe($data['Civilite']);
                    $personne->setPrenom($data['Prenom']);
                    $personne->setNom($data['Nom']);
                    $personne->setIsAdmin(0);
                    $personne->setMail($data['Email']);
                    $personne->setTelephone($data['Tel']);
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
                    return $this->redirect('/PTUT-2015-2016/web/app_dev.php/entreprise/ajout_annonce');
                }
            }

            return $this->render(
                'SiteBundle:Default:ajoutAnnonce.html.twig',
                ['form' => $form->createView(),'form2' => $form2->createView(),'maps'=>$maps]
            );
        }
    }

    public function inscriptionAction(Request $request)
    {
        //TODO  $form = $this->createForm(PostulerAnnonce::class);
        $form = $this->createForm(PostulerAnnonce::class);;
        return $this->render(
            'SiteBundle:Entreprise:inscription_entreprise.html.twig'
            , ['form' => $form->createView()]
        );
    }
}
