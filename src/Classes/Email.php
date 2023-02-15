<?php
namespace App\Classes;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailSender
{
    private $mailer;
    /**
     * @param MailerInterface $mailer
     * @param $to string
     * @param $subject string
     * @param $body string
     * @param $from string
     */

    public function __construct(MailerInterface $mailer,Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendInscriptionEmail($to, $from, $subject,$body,$lienTemplate,$parametres)
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($body)
            ->html(
                $this->twig->render($lienTemplate,$parametres),'UTF-8');


            $this->mailer->send($email);
    }
}

?>