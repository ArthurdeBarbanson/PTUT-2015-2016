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

            if ($request->isMethod('post')) {
                $form->submit($request);
                if ($form->isValid()) {

                    $data = $form->getData();
                    $dateDepot= new DateTime();
                    $dateDepot->format('Y-m-d H');

                    $annonce= new Offre(
                        uniqid(),
                        $dateDepot,
                        "En attende de Validation",
                        $data['Sujet'],
                        $data['Titre']

                    );

                    $this->container->get('offre_repository')->save($annonce);

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
