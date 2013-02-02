<?php

namespace SamlTest\Md\Entity;

use Saml\Md\Entity\EntityFactory;


class EntityFactoryTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateEntity()
    {
        $factory = new EntityFactory();
        $this->assertInstanceOf('Saml\Md\Entity\Entity', $factory->createEntity(new \DOMDocument()));
    }
}