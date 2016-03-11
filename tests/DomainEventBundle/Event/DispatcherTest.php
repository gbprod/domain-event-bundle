<?php

namespace Tests\GBProd\DomainEventBundle\Dispatcher;

use GBProd\DomainEventBundle\Event\Dispatcher;
use GBProd\DomainEvent\DomainEvent;
use GBProd\DomainEvent\EventProvider;
use GBProd\DomainEvent\EventProviderTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Tests for Dispatcher
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase implements EventProvider
{
    use EventProviderTrait;
    
    public function testConstruct()
    {
        new Dispatcher(
            $this->getMock(EventDispatcherInterface::class)
        );
    }
    
    public function testDispatchEvent()
    {
        $event = $this->getMock('GBProd\DomainEvent\DomainEvent');
        $this->raise($event);
        
        $symfonyDispatcher = $this->getMock(EventDispatcherInterface::class);
        
        $symfonyDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                'DispatcherTest.'.get_class($event),
                $this->isInstanceOf(SymfonyEvent::class)
            )
        ;
        
        $dispatcher = new Dispatcher($symfonyDispatcher);
        
        $dispatcher->dispatch($this);
    }
}