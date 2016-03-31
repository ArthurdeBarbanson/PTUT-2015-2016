<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Forms\Types\AjoutEtudiant;

class ResponsableController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function ajoutEtudiantAction()
    {
        $user= $this->container->get('security.context')->getToken()->getUser();
        $form=$this->createForm(AjoutEtudiant::class);

        if($form->isValid()){
            $this->addFlash('success',"l'étudiant à été ajouter !");
        }else{
            $this->addFlash('erreur',"Une erreur est survenu lors de l'ajout d'un étudiant.");
        }


        return $this->render('SiteBundle:Responsable:ajoutEtudiant.html.twig',[
            'form'=> $form->createView(),
            'user'=>$user
        ]);
    }
}
