<?php

namespace SamlTest\Md\Entity\Collection;

use Saml\Md\Entity\Collection\Collection;


class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Collection
     */
    protected $collection = null;


    public function setUp()
    {
        $this->collection = new Collection();
    }


    public function testAddEntityWithNoId()
    {
        $this->setExpectedException('Saml\Md\Entity\Collection\Exception\NoEntityIdException');
        
        $entity = $this->_getEntityMock();
        
        $this->collection->add($entity);
    }


    public function testAddOk()
    {
        $entityId = 'testid';
        $entity = $this->_getEntityMock($entityId);
        $this->collection->add($entity);
        $this->assertSame($entity, $this->collection->get($entityId));
    }


    public function testAddEntityWithDuplicateId()
    {
        $this->setExpectedException('Saml\Md\Entity\Collection\Exception\DuplicateEntityIdException');
        
        $entityId = 'testid';
        $entity1 = $this->_getEntityMock($entityId);
        $entity2 = $this->_getEntityMock($entityId);
        
        $this->collection->add($entity1);
        $this->collection->add($entity2);
    }


    public function testGetNonExistentEntity()
    {
        $this->assertNull($this->collection->get('foo'));
    }

    
    public function testGetCount()
    {
        $this->assertSame(0, $this->collection->count());
        
        $this->collection->add($this->_getEntityMock('entity1'));
        $this->assertSame(1, $this->collection->count());
        
        $this->collection->add($this->_getEntityMock('entity2'));
        $this->assertSame(2, $this->collection->count());
    }
    
    
    public function testGetIterator()
    {
        $this->assertInstanceOf('Traversable', $this->collection->getIterator());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getEntityMock($entityId = null)
    {
        $entity = $this->getMockBuilder('Saml\Md\Entity\Entity')
            ->disableOriginalConstructor()
            ->getMock();
        
        $entity->expects($this->once())
            ->method('getId')
            ->will($this->returnValue($entityId));
        
        return $entity;
    }
}