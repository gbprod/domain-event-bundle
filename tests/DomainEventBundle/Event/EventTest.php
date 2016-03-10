<?php

namespace Tests\GBProd\DomainEventBundle\Dispatcher;

use GBProd\DomainEventBundle\Event\Event;
use GBProd\DomainEvent\DomainEvent;

/**
 * Tests for Dispatcher
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $domainEvent = $this->getMock(DomainEvent::class);
        
        $event = new Event($domainEvent);
        
        $this->assertEquals(
            $domainEvent,
            $event->getDomainEvent()
        );
    }
}