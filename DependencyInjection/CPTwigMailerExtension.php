<?php

namespace CoopersPeele\Bundle\TwigMailerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * PCPTwigMailer bundle extension.
 *
 * @author     Coopers Peele <info@coopers-peele.com>
 * @copyright  2016 CoopersPeele Limited
 */
class CPTwigMailerExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @param mixed[]          $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');
    }
}
