<?php

namespace SamlTest\Md\Entity;

use Saml\Md\Entity\Entity;


class EntityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Entity
     */
    protected $entity;


    public function setUp()
    {
        $metadataDom = new \DOMDocument('1.0', 'utf-8');
        $metadataDom->load(PHPSAMLMD_TESTS_DATA_DIR . '/idp-metadata.xml');
        
        $this->entity = new Entity($metadataDom);
    }


    public function testGetId()
    {
        $this->assertSame('https://whoami.cesnet.cz/idp/shibboleth', $this->entity->getId());
    }


    public function testGetType()
    {
        $this->assertSame(Entity::TYPE_IDP, $this->entity->getType());
    }


    public function testGetXpath()
    {
        $this->assertInstanceOf('DOMXPath', $this->entity->getXpath());
    }
}