<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Forms\Types\AjoutEtudiant;
use Symfony\Component\HttpFoundation\Request;

class ResponsableController extends Controller
{
    public function accueilAction()
    {
        return $this->render('SiteBundle:Responsable:accueil_responsable.html.twig');
    }

    public function ajoutEtudiantAction(Request $request)
    {
//        $repositoryUser= $this
//            ->getDoctrine()
//            ->getManager()
//            ->getRepository('SiteBundle:User');
//        $user = $this->getUser();
        $id=$this->getUser();



        $form=$this->createForm(AjoutEtudiant::class);

        $form->handleRequest($request);
        if($form->isValid()){
            $this->addFlash('success',"l'étudiant à été ajouter !");
        }else{
            $this->addFlash('erreur',"Une erreur est survenu lors de l'ajout d'un étudiant.");
        }


        return $this->render('SiteBundle:Responsable:ajoutEtudiant.html.twig',[
            'form'=> $form->createView(),
            'id'=> $id
        ]);
    }
}
