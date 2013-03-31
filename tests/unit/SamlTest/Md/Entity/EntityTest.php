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


    public function testGetOrganizationInfo()
    {
        $expectedValue = array(
            'en' => array(
                'OrganizationName' => 'CESNET',
                'OrganizationDisplayName' => 'CESNET, a. l. e.',
                'OrganizationURL' => 'http://www.ces.net/'
            ),
            'cs' => array(
                'OrganizationName' => 'CESNET',
                'OrganizationDisplayName' => 'CESNET, z. s. p. o.',
                'OrganizationURL' => 'http://www.cesnet.cz/'
            )
        );
        
        $this->assertSame($expectedValue, $this->entity->getOrganizationInfo());
    }


    public function testGetContactInfo()
    {
        $expectedValue = array(
            array(
                'info' => Array(
                    'GivenName' => 'Ivan',
                    'SurName' => 'Novakov',
                    'EmailAddress' => 'novakoi@fel.cvut.cz'
                ),
                
                'type' => 'technical'
            ),
            
            array(
                'info' => array(
                    'GivenName' => 'Jan',
                    'SurName' => 'Tomášek',
                    'EmailAddress' => 'jan.tomasek@cesnet.cz'
                ),
                
                'type' => 'technical'
            )
        );
        
        $this->assertSame($expectedValue, $this->entity->getContactInfo());
    }


    public function testGetXpathFactoryAfterSet()
    {
        $xpathFactory = $this->getMock('Saml\Md\Parser\XpathFactory');
        $this->entity->setXpathFactory($xpathFactory);
        $this->assertSame($xpathFactory, $this->entity->getXpathFactory());
    }


    public function testGetXpathFactoryImplicit()
    {
        $xpathFactory = $this->entity->getXpathFactory();
        $this->assertInstanceOf('Saml\Md\Parser\XpathFactory', $xpathFactory);
    }


    public function testGetXpath()
    {
        $this->assertInstanceOf('DOMXPath', $this->entity->getXpath());
    }


    public function testQueryXpath()
    {
        $xpath = $this->getMockBuilder('DomXPath')
            ->disableOriginalConstructor()
            ->getMock();
        
        $xpathFactory = $this->getMock('Saml\Md\Parser\XpathFactory');
        $xpathFactory->expects($this->once())
            ->method('createXpath')
            ->with($this->isInstanceOf('DomDocument'))
            ->will($this->returnValue($xpath));
        $this->entity->setXpathFactory($xpathFactory);
        
        $this->assertSame($xpath, $this->entity->getXpath());
    }
}