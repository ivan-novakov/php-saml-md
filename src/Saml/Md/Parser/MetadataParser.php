<?php

namespace Saml\Md\Parser;


class MetadataParser
{

    /**
     * DOM parser
     * @var DomParser
     */
    protected $domParser = null;


    /**
     * Constructor.
     * 
     * @param DomParser $domParser
     */
    public function __construct(DomParser $domParser = null)
    {
        if (null === $domParser) {
            $domParser = new DomParser();
        }
        
        $this->domParser = $domParser;
    }


    public function parseDom(DomDocument $mdDom)
    {
        $entityNodes = $mdDom->getElementsByTagName('EntityDescriptor');
        
        $collection = new EntityCollection();
        foreach ($entityNodes as $entityNode) {
            /* @var $entityNode DOMNode */
            $entityDom = $this->domParser->createNewDomDocument();
            $entityDom->appendChild($entityDom->importNode($entityNode, true));
            $entity = new Entity($entityDom);
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