<?php

namespace Tests\GBProd\DomainEventBundle;

use GBProd\DomainEventBundle\DomainEventBundle;

/**
 * Tests for DomainEventBundle
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class DomainEventBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        new DomainEventBundle();
    }
}