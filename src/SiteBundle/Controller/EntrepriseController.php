<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\Entreprise;
use SiteBundle\Entity\Offre;
use SiteBundle\Entity\MAP;
use SiteBundle\Entity\Personne;
use SiteBundle\Forms\Types\CreateAnnonce;
use SiteBundle\Forms\Types\CreateMap;
use SiteBundle\Forms\Types\EntrepriseType;
use SiteBundle\Forms\Types\InscriptionEntreprise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends Controller
{


    public function accueilAction (){

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Entreprise');

        $entreprise =$repository->find(2);

        $repositoryOffre = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offres = $repositoryOffre->findBy(array("Entreprise"=>$entreprise));

        $repositoryPostulant= $this->getDoctrine()->getManager()->getRepository('SiteBundle:EtudiantOffre');
        $postulantOffres = array(); $result= array();
        foreach($offres as $offre){
            $id = $offre->getId();

            $postulantOffres= array($id=>$repositoryPostulant->findBy(array("Offre"=>$offre)));
            $result = array_merge($postulantOffres,$result);
        }
            return $this->render(
            'SiteBundle:Entreprise:accueil_entreprise.html.twig',
            ['offres'=>$offres,'postulantOffres'=>$result]
        );
    }

    public function ajoutAnnonceAction(Request $request){
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:Entreprise');

            $entreprise =$repository->find(2);

            $form = $this->createForm(CreateAnnonce::class);
            $form2 = $this->createForm(CreateMap::class);
            $em = $this->getDoctrine()->getManager() ;


            $repositoryMap = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:MAP');

            $maps = $repositoryMap->findBy(array("Entreprise"=>$entreprise));


            if ($request->isMethod('post')) {
               $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $dateDepot= new DateTime();
                    $dateDepot->format('Y-m-d H');
                    $map = $repositoryMap->find($request->request->get('map'));

                    $annonce= new Offre;
                    $annonce->setDateDepot($dateDepot);
                    $annonce->setEtatOffre("En attende de Validation");
                    $annonce->setSujet($data['Sujet']);
                    $annonce->setTitre($data['Titre']);
                    $annonce->setLicenceConcerne(($data['Lpconcerne']));
                    $annonce->setEntreprise($entreprise);
                    $annonce->setMAP($map);

                    $em->persist($annonce);
                    $em->flush();
                    $this->addFlash('info', "L'annonce a été mis en attente de Validation.");

                    return $this->redirect('/PTUT-2015-2016/web/app_dev.php/entreprise');
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
        $entreprise= new Entreprise();
        $form = $this->createForm(EntrepriseType::class,$entreprise);;

        $form->handleRequest();
        if($form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Inscription terminé avec succès !');

            return $this->redirect($this->generateUrl('a'));

        }


        return $this->render(
            'SiteBundle:Entreprise:inscription_entreprise.html.twig'
            , ['form' => $form->createView()]
        );
    }
    public function detailsPostulantsAction(Request $request){

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
            'SiteBundle:Entreprise:detailsPostulants.html.twig',['postulant' => $offre]

        );

    }
}
