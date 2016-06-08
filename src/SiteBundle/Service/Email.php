<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 06/06/16
 * Time: 09:10
 */

namespace SiteBundle\Service;
use Symfony\Component\Templating\EngineInterface;

class Email
{
    protected $mailer;
    protected $templating;
    private $from = "no-reply@example.fr";
    private $name = "Equipe Acme Blog";

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail($from, $to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
    public function sendEmailTemplate($from, $to, $subject, $body, Array $parametre)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($this->templating->render($body, $parametre))
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}