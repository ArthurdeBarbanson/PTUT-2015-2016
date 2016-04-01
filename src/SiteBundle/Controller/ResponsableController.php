<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SiteBundle\Forms\Types\AjoutEtudiant;
use Symfony\Component\HttpFoundation\Request;

class ResponsableController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function ajoutEtudiantAction(Request $request)
    {
        $user= $this->container->get('security.token_storage')->getToken()->getUser();
        $form=$this->createForm(AjoutEtudiant::class);

        $form->handleRequest($request);
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
