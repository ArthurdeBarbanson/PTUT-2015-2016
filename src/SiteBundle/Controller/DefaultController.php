<?php

namespace SiteBundle\Controller;

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


}
