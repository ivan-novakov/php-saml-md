<?php

namespace Saml\Md\Parser;


class XpathFactory
{

    /**
     * Metadata namespaces.
     * 
     * @var array
     */
    protected $metadataNamespaces = array();


    /**
     * Constructor.
     * 
     * @param array $metadataNamespaces
     */
    public function __construct(array $metadataNamespaces = null)
    {
        if (null === $metadataNamespaces) {
            $metadataNamespaces = Namespaces::getMetadataNamespaces();
        }
        
        $this->metadataNamespaces = $metadataNamespaces;
    }


    /**
     * Creates and returns a DOM Xpath object.
     * 
     * @param \DOMDocument $dom
     * @return \DOMXPath
     */
    public function createXpath(\DOMDocument $dom)
    {
        $xpath = new \DOMXPath($dom);
        foreach ($this->metadataNamespaces as $prefix => $uri) {
            $xpath->registerNamespace($prefix, $uri);
        }
        
        return $xpath;
    }
}