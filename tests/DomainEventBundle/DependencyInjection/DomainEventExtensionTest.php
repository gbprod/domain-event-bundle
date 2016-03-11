<?php

namespace Tests\GBProd\DomainEventBundle\DependencyInjection;

use GBProd\DomainEventBundle\DependencyInjection\DomainEventExtension;
use GBProd\DomainEventBundle\Event\Dispatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Tests for DomainEventExtension
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class DomainEventExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;
    private $container;

    protected function setUp()
    {
        $this->extension = new DomainEventExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
        
    }
    
    public function testLoadDispatcher()
    {
        $this->container->set(
            'event_dispatcher',
            $this->getMock(EventDispatcherInterface::class)
        );
        
        $this->container->loadFromExtension($this->extension->getAlias());
        $this->container->compile();
     
        $this->assertTrue(
            $this->container->has('gbprod.domain_event_dispatcher')
        );
        
        $dispatcher = $this->container->get('gbprod.domain_event_dispatcher');
        
        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
    }

}