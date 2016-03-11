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
class DispatcherTest extends \PHPUnit_Framework_TestCase implements DomainEvent
{
    public function getAggregateId()
    {
        return 1;
    }
    
    public function testConstruct()
    {
        new Dispatcher(
            $this->getMock(EventDispatcherInterface::class)
        );
    }
    
    public function testDispatchEvent()
    {
        $symfonyDispatcher = $this->getMock(EventDispatcherInterface::class);
        
        $symfonyDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                'DispatcherTest',
                $this->isInstanceOf(SymfonyEvent::class)
            )
        ;
        
        $dispatcher = new Dispatcher($symfonyDispatcher);
        
        $dispatcher->dispatch($this);
    }
}