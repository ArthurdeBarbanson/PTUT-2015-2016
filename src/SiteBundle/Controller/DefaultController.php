<?php

namespace SiteBundle\Controller;

use Proxies\__CG__\SiteBundle\Entity\Entreprise;
use Proxies\__CG__\SiteBundle\Entity\Offre;
use SiteBundle\Forms\Types\CreateAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteBundle:Default:index.html.twig');
    }

    public function ajoutAnnonceAction(Request $request){
        {
            $form = $this->createForm(CreateAnnonce::class);

            if ($request->isMethod('post')) {
                $form->submit($request);
                if ($form->isValid()) {

                    $data = $form->getData();

                    $annonce= new Annonce(
                        uniqid(),
                        $data['name'],
                        $data['description'],
                        $data['price']
                    );

                    $this->container->get('product_repository')->save($product);

                    $this->addFlash('info', "Le produit a bien été ajouté.");

                    return $this->redirect('/');
                }
            }

            return $this->render(
                'MetinetECommerceBundle:Default:addProduct.html.twig',
                ['form' => $form->createView()]
            );
        }
    }

    public function detailAnnonceAction(Request $request){
        $offre = new Offre();
        $entreprise = new Entreprise();
        $entreprise->setDescription("Une entreprise qui est jolie parfois");
        $entreprise->setNom("Nom de l'entreprise");
        
        $offre->setSujet("Coool");
        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig'
            ,['offre' => $offre]
        );
    }
}
