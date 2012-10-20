<?php

namespace MdView\Parser;

use MdView\Entity\Entity;
use MdView\Entity\EntityCollection;
use DOMDocument;


class Parser
{


    public function __construct ()
    {}


    public function parseDom (DomDocument $mdDom)
    {
        $entityNodes = $mdDom->getElementsByTagName('EntityDescriptor');
        
        $collection = new EntityCollection();
        foreach ($entityNodes as $entityNode) {
            /* @var $entityNode DOMNode */
            $entityDom = $this->_createDom();
            $entityDom->appendChild($entityDom->importNode($entityNode, true));
            $entity = new Entity($entityDom);
            $collection->add($entity);
        }
        
        return $collection;
    }


    public function parseString ($mdString)
    {
        $mdDom = $this->_createDom();
        $mdDom->loadXml($mdString);
        if (false === $mdDom) {
            throw new Exception\ParseException('Error loading XML to DOM Document');
        }
        
        return $this->parseDom($mdDom);
    }


    public function parseFile ($mdFile)
    {
        $mdString = file_get_contents($mdFile);
        if (false === $mdString) {
            throw new Exception\ParseException(sprintf("Error reading file '%s'", $mdFile));
        }
        
        return $this->parseString($mdString);
    }


    protected function _createDom ()
    {
        return new DomDocument('1.0', 'utf-8');
    }
}