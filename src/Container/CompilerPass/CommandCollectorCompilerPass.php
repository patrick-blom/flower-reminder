<?php

namespace FlowerReminder\Container\CompilerPass;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CommandCollectorCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('flower_reminder.command') as $id => $attr) {

            $definition = $container->getDefinition($id);
            if (!$definition->isPublic()) {
                throw new \InvalidArgumentException(sprintf('Command "%s" must be public.', $id));
            }

            $command = $container->get($id);
            if ($command instanceof Command) {
                $application = $container->get('flower_reminder.application');
                $application->add($command);
            }
        }
    }
}
