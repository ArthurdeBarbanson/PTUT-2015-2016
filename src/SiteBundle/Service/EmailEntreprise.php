<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08/06/16
 * Time: 20:57
 */

namespace SiteBundle\Service;


class EmailEntreprise extends Email
{
    public function inscriptionEntreprise($adresseMail,$password){
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom('noreply-suivilpmetinet@iutinfobourg.fr')
            ->setTo($adresseMail)
            ->setSubject("inscription entreprise")
            ->setBody(
                $this->templating->render(
                    'Emails/ajoutEntreprise.html.twig', [
                        'password' => $password,
                        'adresse' => $adresseMail
                    ]
                )
            )
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}