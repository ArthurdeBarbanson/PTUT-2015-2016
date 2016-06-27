<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 06/06/16
 * Time: 09:10
 */

namespace SiteBundle\Service;
use Symfony\Component\Templating\EngineInterface;
use Doctrine\ORM\EntityManager;

class Email
{
    protected $mailer;
    protected $templating;
    /** @var  Registry */
    protected $doctrine;




    public function __construct($mailer, EngineInterface $templating,$doctrine)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->doctrine = $doctrine;

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