<?php

namespace GBProd\DomainEventBundle\Event;

use GBProd\DomainEvent\Dispatcher as DomainEventDispatcher;
use GBProd\DomainEvent\DomainEvent;
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
    public function dispatch(DomainEvent $event)
    {
        $this->dispatcher->dispatch(
            $this->resolveEventName($event),
            new Event($event)
        );
    }
    
    private function resolveEventName(DomainEvent $event)
    {
        $name = get_class($event);
        $pos = strrpos($name, '\\');

        return $this->name = false === $pos ? $name : substr($name, $pos + 1);
    }
}