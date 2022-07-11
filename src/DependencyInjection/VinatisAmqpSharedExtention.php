<?php

namespace Vinatis\Bundle\AmqpSharedBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Serializer\SharedSerializer;
use Vinatis\Bundle\AmqpSharedBundle\MessageTypeChain;
use Vinatis\Bundle\SecurityLdapBundle\Bridge\Symfony\Security\Core\User\UserChecker;


final class VinatisAmqpSharedExtention extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container
            ->register(MessageTypeChain::class, MessageTypeChain::class)
            ->setArguments([$config['messages']])
        ;

        $container
            ->register(SharedSerializer::class, SharedSerializer::class)
            ->setArguments([$container->getDefinition(MessageTypeChain::class)])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias(): string
    {
        return 'vinatis_amqp_shared';
    }
}