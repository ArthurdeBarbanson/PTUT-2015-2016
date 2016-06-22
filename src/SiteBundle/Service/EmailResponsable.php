<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 07/06/16
 * Time: 11:06
 */

namespace SiteBundle\Service;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Templating\EngineInterface;


class EmailResponsable
{
    protected $mailer;
    protected $templating;
    public $entity;
    /** @var  Registry */
    private $doctrine;

    public function __construct($mailer, EngineInterface $templating, EntityManager $entityManager,$doctrine)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->$entity = $entityManager;
        $this->doctrine = $doctrine;
//        $this->$repoyPieceJointe = $repoyPieceJointe;
    }

    public function envoyerMailEtape($adresseMail,$etape){

        $this->entity->getRepository('');
        $this->doctrine->getRepository('SiteBunble:Offre');
//        $this->setRepositoryEmail($this->repositoryEmail);
//        $this->setRepositoryPieceJointe($this->$repositoryPieceJointe);

        $pieceJointe=$this->$repositoryPieceJointe->findBy(['Etape'=>$etape]);
        $listeEmails = $this->$repositoryEmail->find(1);
        $body="Aucune étape sélectionner !";

        switch($etape){
            case '1':
                $body=$listeEmails->getEtape1();
                break;
            case '2':
                $body=$listeEmails->getEtape2();
                break;
            case '3':
                $body=$listeEmails->getEtape3();
                break;
            case '4':
                $body=$listeEmails->getEtape4();
                break;
            case '5':
                $body=$listeEmails->getEtape5();
                break;
            case '6':
                $body=$listeEmails->getEtape6();
                break;
        }

        $mail = \Swift_Message::newInstance();
        $mail
            ->setFrom('noreply-suivilpmetinet@iutinfobourg.fr')
            ->setTo($adresseMail)
            ->setSubject("Avancement inscription pédagogique")
            ->setBody($body)
            ->setContentType('text/html');

        if(!empty($pieceJointe)){
            foreach($pieceJointe as $piecej){
                $mail->attach($piecej['chemin']);
            }
        }

        $this->mailer->send($mail);
    }

    public function refuserAnnonce($adresseMail,$message){
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom('noreply-suivilpmetinet@iutinfobourg.fr')
            ->setTo($adresseMail)
            ->setSubject("Refus de l'annonce : ")
            ->setBody(
                $this->templating->render(
                    'Emails/refusAnnonce.html.twig', [
                        'message' => $message
                    ]
                )
            )
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function modifierAnnonce($adresseMail,$message){
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom('noreply-suivilpmetinet@iutinfobourg.fr')
            ->setTo($adresseMail)
            ->setSubject("Demande de modification de l'annonce : ")
            ->setBody(
                $this->templating->render(
                    'Emails/ModificationAnnonce.html.twig', [
                        'message' => $message
                    ]
                )
            )
            ->setContentType('text/html');
        $this->mailer->send($mail);
    }
}