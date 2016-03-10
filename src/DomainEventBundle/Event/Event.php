<?php

namespace GBProd\DomainEventBundle\Event;

use GBProd\DomainEvent\DomainEvent;
use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 * Symfony event wrapping domain event
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class Event extends BaseEvent
{
    /**
     * @param DomainEvent $domainEvent
     */
    public function __construct(DomainEvent $domainEvent)
    {
        $this->domainEvent = $domainEvent;
    }
    
    /**
     * Return wrapped domain event
     * 
     * @return DomainEvent
     */
    public function getDomainEvent()
    {
        return $this->domainEvent; 
    }
}