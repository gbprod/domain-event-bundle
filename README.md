# Domain event bundle

[![Build Status](https://travis-ci.org/gbprod/domain-event-bundle.svg?branch=master)](https://travis-ci.org/gbprod/domain-event-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gbprod/domain-event-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gbprod/domain-event-bundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gbprod/domain-event-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gbprod/domain-event-bundle/?branch=master)

[![Latest Stable Version](https://poser.pugx.org/gbprod/domain-event-bundle/v/stable)](https://packagist.org/packages/gbprod/domain-event) 
[![Total Downloads](https://poser.pugx.org/gbprod/domain-event-bundle/downloads)](https://packagist.org/packages/gbprod/domain-event) 
[![Latest Unstable Version](https://poser.pugx.org/gbprod/domain-event-bundle/v/unstable)](https://packagist.org/packages/gbprod/domain-event) 
[![License](https://poser.pugx.org/gbprod/domain-event-bundle/license)](https://packagist.org/packages/gbprod/domain-event)

Integrates [domain event](https://github.com/gbprod/domain-event) library to a Symfony application

## Installation

With composer :

```bash
composer require gbprod/domain-event-bundle
```

Update your `app/AppKernel.php` file:

```php
public function registerBundles()
{
    $bundles = array(
        new GBProd\DomainEventBundle\DomainEventBundle(),
    );
}
```

## Setup your entity

Use [domain event](https://github.com/gbprod/domain-event) library to raise events :

```php
<?php

namespace GBProd\Acme\Entity;

use GBProd\DomainEvent\EventProvider;
use GBProd\DomainEvent\EventProviderTrait;

final class MyEntity implements EventProvider
{
    use EventProviderTrait;

    public function doSomething()
    {
        $this->raise(
            new SomethingHappenedEvent($this->id)
        );
    }
}
```

## Dispatch events from your repository

Example with Doctrine repository :

```php
<?php

namespace GBProd\AcmeBundle\Repository;

use GBProd\DomainEvent\EventProvider;
use GBProd\DomainEvent\Dispatcher;

class MyEntityRepository
{
    public function __construct(EntityManager $em, DomainEventDispatcher $dispatcher)
    {
        $this->em         = $em;
        $this->dispatcher = $dispatcher;
    }
    
    public function save(MyEntity $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
        
        $this->dispatcher->dispatch($entity);
    }
}
```

```yaml
# src/GBProd/AcmeBundle/Resourses/config/services.yml
services:
    gbprod_acme.my_entity_repository:
        class: GBProd\AcmeBundle\Repository\MyEntityRepository
        arguments:
            - "@doctrine.entity_manager"
            - "@gbprod.domain_event_dispatcher"
```

This will dispatch events using Symfony [Event dispatcher](https://github.com/symfony/event-dispatcher).
The name of the event will be the classname of the aggregate and the event (`MyEntity.SomethingHappenedEvent` in this example).

## Create your listener

```php
<?php

namespace GBProd\AcmeBundle\Listener;

use Symfony\Component\EventDispatcher\Event;

class MyListener
{
    public function onSomethingHappened(Event $event) 
    {
        $domainEvent = $event->getDomainEvent();
        
        // Use it now
    }
}
```

## Register your listener

```yaml
gbprod_acme.event_listener.my_listener:
    class: GBProd\AcmeBundle\Listener\MyListener
    tags:
        - { name: kernel.event_listener, event: MyEntity.SomethingHappenedEvent, method: 'onSomethingHappened' }
```