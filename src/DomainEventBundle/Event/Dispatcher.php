<?php

namespace GBProd\DomainEventBundle\Event;

use GBProd\DomainEvent\Dispatcher as DomainEventDispatcher;
use GBProd\DomainEvent\DomainEvent;
use GBProd\DomainEvent\EventProvider;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Domain dispatcher implementation for symfony dispatcher
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class Dispatcher implements DomainEventDispatcher
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    
    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(EventProvider $provider)
    {
        foreach ($provider->popEvents() as $event) {
            $this->dispatcher->dispatch(
                $this->resolveEventName($provider, $event),
                new Event($event)
            );
        }
    }
    
    private function resolveEventName(EventProvider $provider, DomainEvent $event)
    {
        return sprintf(
            '%s.%s',
            $this->getClassname($provider),
            $this->getClassname($event)
        );
    }
    
    private function getClassname($object)
    {
        $name = get_class($object);
        $pos = strrpos($name, '\\');

        return $this->name = false === $pos ? $name : substr($name, $pos + 1);
    }
}