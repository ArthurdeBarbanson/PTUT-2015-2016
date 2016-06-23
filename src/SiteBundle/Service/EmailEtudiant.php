<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08/06/16
 * Time: 11:24
 */

namespace SiteBundle\Service;

use SiteBundle\Repository\EmailEtapeInscriptionRepository;
use SiteBundle\Repository\PieceJointeRepository;

class EmailEtudiant extends Email
{

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