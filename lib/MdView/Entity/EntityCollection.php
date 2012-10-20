<?php

namespace MdView\Entity;


class EntityCollection implements \Countable, \IteratorAggregate
{

    /**
     * Entities data.
     *
     * @var \ArrayObject
     */
    protected $_entities = null;


    public function __construct ()
    {
        $this->_entities = new \ArrayObject(array());
    }


    public function add (Entity $entity)
    {
        $entityId = $entity->getId();
        
        if (! $entityId) {
            throw new Exception\EmptyEntityIdException('Cannot add entity with empty ID');
        }
        
        if ($this->_entities->offsetExists($entityId)) {
            throw new Exception\EntityExistsException(
                    sprintf("Entity with ID '%s' already exists in the collection", $entityId));
        }
        
        $this->_entities->offsetSet($entityId, $entity);
    }


    public function count ()
    {
        return $this->_entities->count();
    }


    public function getIterator ()
    {
        return $this->_entities->getIterator();
    }
}