<?php

namespace CoopersPeele\Bundle\TwigMailerBundle\Mailer;

use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

class TwigSwiftMailer implements TwigSwiftMailerInterface
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
    public function sendMessage($toEmail, $fromEmail, $template_name, array $context = array())
    {
        $message = $this->prepareMessage($toEmail, $fromEmail, $template_name, $context);

        return $this->getMailer()->send($message);
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function prepareMessage($toEmail, $fromEmail, $template_name, array $context = array())
    {
        $twig = $this->getTwig();

        $context = $twig->mergeGlobals($context);
        $template = $twig->loadTemplate($template_name);
        $subject = $template->renderBlock('subject', $context);
        $body_text = $template->renderBlock('body_text', $context);
        $body_html = $template->renderBlock('body_html', $context);

        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        if (!empty($body_html)) {
            $message->setBody($body_html, 'text/html')
                ->addPart($body_text, 'text/plain');
        } else {
            $message->setBody($body_text);
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
