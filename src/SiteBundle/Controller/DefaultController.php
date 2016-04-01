<?php

namespace SiteBundle\Controller;

use Proxies\__CG__\SiteBundle\Entity\Entreprise;
use Proxies\__CG__\SiteBundle\Entity\Offre;
use SiteBundle\Forms\Types\PostulerAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteBundle:Default:index.html.twig');
    }

    public function testAction()
    {
        return $this->render('SiteBundle:Default:test.html.twig');
    }

    public function detailAnnonceAction(Request $request)
    {
        $annonceId = $request->get('annonceId');
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:Offre');

        $offre = $repository->find($annonceId);
        //si l'annonce n'es pas trouvé
        if (null === $offre) {
            throw new NotFoundHttpException("L'annonce n'a pas été trouvée.");
        }

        $form = $this->createForm(PostulerAnnonce::class);

        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                //TODO envoyer
            }
        }

        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig'
            , ['offre' => $offre, 'annonceId' => $annonceId
                , 'form' => $form->createView()]
        );
    }
}
