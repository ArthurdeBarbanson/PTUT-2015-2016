<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\EtudiantOffre;
use SiteBundle\Forms\Types\PostulerAnnonce;
use SiteBundle\Forms\Types\RechercheOffresType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

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
                //TODO etudiant pas bien chargé
                $repository = $this->getDoctrine()->getManager()->getRepository('SiteBundle:Etudiant');
                $etudiant = $repository->find($this->getUser()->getIdEtudiant());

                $data = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $etudiant_offre = new EtudiantOffre;
                $etudiant_offre->setDate(new \DateTime());
                $etudiant_offre->setLettreMotivation($data['lettreMotivation']);
                $etudiant_offre->setOffre($offre);
                $etudiant_offre->setEtudiant($etudiant);

                $em->persist($etudiant_offre);
                $em->flush();
                $this->addFlash('info', "L'offre à bien été enregistrée.");
            }
        }

        return $this->render(
            'SiteBundle:Default:detailsAnnonce.html.twig'
            , ['offre' => $offre, 'annonceId' => $annonceId
                , 'form' => $form->createView()]
        );
    }

    public function listeOffresAction(Request $request)
    {
        $form = $this->createForm(RechercheOffresType::class);
        $offres = array();
        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('SiteBundle:Offre');
                $offres = $repository->findOffresByData($data);
            }
        } else {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SiteBundle:Offre');
            $offres = $repository->findAll();
        }

        return $this->render('SiteBundle:Default:liste_offres.html.twig'
            , ['form' => $form->createView()
                , 'offres' => $offres]);
    }

    public function impressionAnnonceAction(Request $request)
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


        $html = $this->renderView('SiteBundle:Default:impressionAnnonce.html.twig'
            , ['offre' => $offre, 'annonceId' => $annonceId]
        );

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="Annonce.pdf"'
            )
        );
    }
}
