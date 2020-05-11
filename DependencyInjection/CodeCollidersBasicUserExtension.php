<?php

namespace CodeColliders\BasicUserBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CodeCollidersBasicUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $authenticator = $container->getDefinition('code_colliders_basic_user.authenticator');
        $authenticator->setArgument('$userClass', $config['user_class']);
        $authenticator->setArgument('$redirectRoute', $config['redirect_route']);
        $authenticator->setArgument('$userIdentifier', $config['user_identifier']);
        $controller = $container->getDefinition('code_colliders_basic_user.authentication_controller');
        $controller->setArgument('$branding', $config['branding']);
        $controller->setArgument('$userIdentifier', $config['user_identifier']);

    }
}
