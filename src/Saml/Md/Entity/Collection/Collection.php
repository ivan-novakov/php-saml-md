<?php

namespace Saml\Md\Entity\Collection;

use Saml\Md\Entity\Entity;


/**
 * Collection of SAML metadata entities.
 *
 */
class Collection implements \Countable, \IteratorAggregate
{

    /**
     * Entities data.
     *
     * @var \ArrayObject
     */
    protected $_entities = null;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->_entities = new \ArrayObject(array());
    }


    /**
     * Adds an entity to the collection.
     * 
     * @param Entity $entity
     * @throws Exception\NoEntityIdException
     * @throws Exception\DuplicateEntityIdException
     */
    public function add(Entity $entity)
    {
        $entityId = $entity->getId();
        
        if (! $entityId) {
            throw new Exception\NoEntityIdException('Cannot add entity with empty ID');
        }
        
        if ($this->_entities->offsetExists($entityId)) {
            throw new Exception\DuplicateEntityIdException(
                sprintf("Entity with ID '%s' already exists in the collection", $entityId));
        }
        
        $this->_entities->offsetSet($entityId, $entity);
    }


    /**
     * Returns the entity with the provided entity ID, if it is contained in the collection.
     * 
     * @param string $entityId
     * @return Entity|null
     */
    public function get($entityId)
    {
        if ($this->_entities->offsetExists($entityId)) {
            return $this->_entities->offsetGet($entityId);
        }
        
        return null;
    }


    /**
     * {@inheritdoc}
     * @see Countable::count()
     */
    public function count()
    {
        return $this->_entities->count();
    }


    /**
     * {@inheritdoc}
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return $this->_entities->getIterator();
    }
}