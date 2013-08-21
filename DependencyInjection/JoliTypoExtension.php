<?php

namespace Joli\TypoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JoliTypoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration  = new Configuration();
        $config         = $this->processConfiguration($configuration, $configs);
        $presets        = array();

        $twig_extension = new Definition('Joli\TypoBundle\Twig\JoliTypoExtension');
        $twig_extension->addTag('twig.extension');
        $container->setDefinition('joli_typo.twig_extension', $twig_extension);

        foreach ($config['presets'] as $name => $preset) {
            $definition = new Definition("%joli_typo.fixer.class%");

            if ($preset['locale']) {
                $definition->addMethodCall('setLocale', array($preset['locale']));
            }

            $fixers = array();
            foreach ($preset['fixers'] as $fixer) {
                // Allow to use services as fixer?
                $fixers[] = $fixer;
            }

            $definition->addArgument($fixers);
            $container->setDefinition(sprintf('joli_typo.fixer.%s', $name), $definition);

            $presets[$name] = new Reference(sprintf('joli_typo.fixer.%s', $name));
        }

        $twig_extension->setArguments(array($presets));

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
