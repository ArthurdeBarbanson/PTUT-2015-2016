<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\Offre;
use SiteBundle\Forms\Types\CreateAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends Controller
{

    public function ajoutAnnonceAction(Request $request){
        {
            $form = $this->createForm(CreateAnnonce::class);
            $em = $this->getDoctrine()->getManager();

            if ($request->isMethod('post')) {
                $form->submit($request);
                if ($form->isValid()) {

                    $data = $form->getData();
                    $dateDepot= new DateTime();
                    $dateDepot->format('Y-m-d H');

                    $annonce= new Offre;
                    $annonce->setDateDepot($dateDepot);
                    $annonce->setEtatOffre("En attende de Validation");
                    $annonce->setSujet($data['Sujet']);
                    $annonce->setTitre($data['Titre']);
                    $annonce->setLicenceConcerne(($data['Lpconcerne']));
                    $annonce->setEntreprise();
                    $em->persist($annonce);
                    $em->flush();
                    $this->addFlash('info', "L'annonce a été mis en attente de Validation.");

                    return $this->redirect('/');
                }
            }

            return $this->render(
                'SiteBundle:Default:ajoutAnnonce.html.twig',
                ['form' => $form->createView()]
            );
        }
    }

}
