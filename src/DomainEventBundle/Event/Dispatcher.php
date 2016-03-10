<?php

namespace GBProd\DomainEventBundle\Event;

use GBProd\DomainEvent\Dispatcher as DomainEventDispatcher;
use GBProd\DomainEvent\DomainEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Domain dispatcher implementation for symfony dispatcher
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class Dispatcher implements DomainEventDispatcher
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;
    
    /**
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatch(DomainEvent $event)
    {
        $this->dispatcher->dispatch(
            get_class($event),
            new Event($event)
        );
    }
}