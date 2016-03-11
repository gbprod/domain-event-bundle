<?php

namespace Tests\GBProd\DomainEventBundle\Dispatcher;

use GBProd\DomainEventBundle\Event\Dispatcher;
use GBProd\DomainEvent\DomainEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Tests for Dispatcher
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        new Dispatcher(
            $this->getMock(EventDispatcherInterface::class)
        );
    }
    
    public function testDispatchEvent()
    {
        $domainEvent = $this->getMock(DomainEvent::class);
        
        $symfonyDispatcher = $this->getMock(EventDispatcherInterface::class);
        
        $symfonyDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                get_class($domainEvent),
                $this->isInstanceOf(SymfonyEvent::class)
            )
        ;
        
        $dispatcher = new Dispatcher($symfonyDispatcher);
        
        $dispatcher->dispatch($domainEvent);
    }
}