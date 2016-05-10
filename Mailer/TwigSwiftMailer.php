<?php

namespace CoopersPeele\Bundle\TwigMailerBundle\Mailer;

use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

class TwigSwiftMailer
{
    protected $mailer;

    protected $twig;

    public function __construct(
        Swift_Mailer $mailer,
        Twig_Environment $twig
    ) {
        $this->mailer = $mailer;

        $this->twig = $twig;
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function sendMessage($toEmail, $fromEmail, $templateName, array $context = array())
    {
        $message = $this->prepareMessage($toEmail, $fromEmail, $templateName, $context);

        return $this->getMailer()->send($message);
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function prepareMessage($toEmail, $fromEmail, $templateName, array $context = array())
    {
        $twig = $this->getTwig();

        $context = $twig->mergeGlobals($context);
        $template = $twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        return $message;
    }

    protected function getMailer()
    {
        return $this->mailer;
    }

    protected function getTwig()
    {
        return $this->twig;
    }
}
