<?php

/*
 * This file is part of the MangopayBundle package.
 *
 * (c) Samuel Gordalina <https://github.com/gordalina/mangopay-bundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Danielcsgomes\Bundle\MailchimpApiConnectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DanielcsgomesMailchimpApiConnectorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($container->getParameter('kernel.debug'));
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('danielcsgomes_mailchimp_api_connector.adapter.class', $config['adapter']['class']);
        $container->setParameter('danielcsgomes_mailchimp_api_connector.apikey', $config['api_key']);
        $container->setParameter('danielcsgomes_mailchimp_api_connector.listid', $config['list_id']);

        $adapter = $container->findDefinition('danielcsgomes_mailchimp_api_connector.adapter');
        foreach ($config['adapter']['arguments'] as $argument) {
            $adapter->addArgument($argument);
        }
    }
}
