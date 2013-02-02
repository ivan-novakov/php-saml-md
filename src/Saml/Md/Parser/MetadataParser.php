<?php

namespace Saml\Md\Parser;

use Saml\Md\Entity;
use \DOMDocument;


class MetadataParser
{

    /**
     * DOM parser
     * @var DomParser
     */
    protected $domParser = null;

    /**
     * Entity factory.
     * 
     * @var Entity\EntityFactoryInterface
     */
    protected $entityFactory = null;


    /**
     * Constructor.
     * 
     * @param DomParser $domParser
     * @param Entity\EntityFactoryInterface $entityFactory
     */
    public function __construct(DomParser $domParser = null, Entity\EntityFactoryInterface $entityFactory = null)
    {
        if (null === $domParser) {
            $domParser = new DomParser();
        }
        $this->domParser = $domParser;
        
        if (null === $entityFactory) {
            $entityFactory = new Entity\EntityFactory();
        }
        $this->entityFactory = $entityFactory;
    }


    /**
     * Parses the DOM and returns a collection of entities.
     * 
     * @param DOMDocument $mdDom
     * @return Entity\Collection\Collection
     */
    public function parseDom(DOMDocument $mdDom)
    {
        $entityNodes = $mdDom->getElementsByTagName('EntityDescriptor');
        
        $collection = new Entity\Collection\Collection();
        foreach ($entityNodes as $entityNode) {
            $entityDom = $this->domParser->createDocumentFromNode($entityNode);
            $entity = $this->entityFactory->createEntity($entityDom);
            $collection->add($entity);
        }
        
        return $collection;
    }


    public function parseString($mdString)
    {
        $mdDom = $this->domParser->parseMetadataString($mdString);
        return $this->parseDom($mdDom);
    }


    public function parseFile($mdFile)
    {
        $mdDom = $this->domParser->parseMetadataFile($mdFile);
        return $this->parseDom($mdDom);
    }
}