<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08/06/16
 * Time: 11:24
 */

namespace SiteBundle\Service;

class EmailEtudiant extends Email
{
    public function envoyerMailEtape($adresseMail,$etape){

        $repository = $this->get('doctrine.orm.entity_manager')->getRepository('SiteBundle:EmailEtapeInscription');

        $repositoryPiecejointe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:PieceJointe');
        $pieceJointe=$repositoryPiecejointe->findBy(['Etape'=>$etape]);

        $listeEmails = $repository->find(1);
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
                $mail->attach($piecej);
            }
        }

        $this->mailer->send($mail);
    }


    public function inscription($adresseMail,$password){
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom('noreply-suivilpmetinet@iutinfobourg.fr')
            ->setTo($adresseMail)
            ->setSubject("inscription étudiant")
            ->setBody(
                $this->templating->render(
                    'Emails/ajoutEtudiant.html.twig', [
                        'password' => $password,
                        'adresse' => $adresseMail
                    ]
                )
            )
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}