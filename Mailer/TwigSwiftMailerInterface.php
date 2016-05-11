<?php

namespace CoopersPeele\Bundle\TwigMailerBundle\Mailer;

interface TwigSwiftMailerInterface
{
    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function sendMessage($toEmail, $fromEmail, $templateName, array $context = array());
}