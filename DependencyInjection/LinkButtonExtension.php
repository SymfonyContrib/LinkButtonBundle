<?php

namespace SymfonyContrib\Bundle\LinkButtonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LinkButtonExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @var string Template file for the link button.
     */
    public $formTemplate = 'LinkButtonBundle:Form:button.html.twig';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        // Configure TwigBundle
        if (isset($bundles['TwigBundle'])) {
            $this->configureTwigBundle($container);
        }
    }

    /**
     * Adds the link button form template to the TwigBundle configuration.
     *
     * @param ContainerBuilder $container The service container
     */
    private function configureTwigBundle(ContainerBuilder $container)
    {
        // Get the twig configurations.
        $name = 'twig';
        $configs = $container->getExtensionConfig($name);

        // Find any existing configurations and add to it them so when the
        // configs are merged they do not overwrite each other.
        foreach ($configs as $config) {
            if (isset($config['form'])) {
                $formConfig = ['form' => $config['form']];
            }
        }

        // Update or create the configuration.
        if (!empty($formConfig)) {
            $formConfig['form']['resources'][] = $this->formTemplate;
        } else {
            $formConfig = [
                'form' => [
                    'resources' => [$this->formTemplate]
                ]
            ];
        }

        // Prepend our configuration.
        $container->prependExtensionConfig($name, $formConfig);
    }
}
