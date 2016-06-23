<?php
namespace SiteBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Templating\EngineInterface;


class EmailResponsable
{
    protected $mailer;
    protected $templating;
    /** @var  Registry */
    private $doctrine;

    public function __construct($mailer, EngineInterface $templating,$doctrine)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->doctrine = $doctrine;

    }

    public function envoyerMailEtape($adresseMail,$etape){

        $repositoryEmail=$this->doctrine->getRepository('SiteBunble:EmailEtapeInscription');
        $repositoryPieceJointe=$this->doctrine->getRepository('SiteBunble:PieceJointe');

        $pieceJointe=$repositoryPieceJointe->findBy(['Etape'=>$etape]);
        $listeEmails = $repositoryEmail->findBy(['etape'=>$etape]);

        $mail = \Swift_Message::newInstance();
        $mail
            ->setFrom('noreply-suivilpmetinet@iutinfobourg.fr')
            ->setTo($adresseMail)
            ->setSubject("Avancement inscription pédagogique")
            ->setBody($listeEmails->getBody())
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