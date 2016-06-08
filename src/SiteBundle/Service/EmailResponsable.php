<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 07/06/16
 * Time: 11:06
 */

namespace SiteBundle\Service;


class EmailResponsable extends Email
{
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