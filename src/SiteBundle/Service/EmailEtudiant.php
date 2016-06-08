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

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('SiteBundle:EmailEtapeInscription');
        $listeEmails = $repository->find(1);

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

        $this->mailer->send($mail);
    }


}