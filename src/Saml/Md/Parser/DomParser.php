<?php

namespace Saml\Md\Parser;

use DOMDocument;
use DOMNode;


class DomParser
{


    /**
     * Parses the provided string and returns the corresponding DOM document.
     * 
     * @param string $mdString
     * @throws Exception\ParseException
     * @return \DOMDocument
     */
    public function parseMetadataString($mdString)
    {
        $mdDom = $this->createNewDomDocument();
        
        // FIXME - collect errors through custom error handler
        $result = @$mdDom->loadXml($mdString);
        if (false === $result) {
            throw new Exception\XmlParseException('Error loading XML to DOM Document');
        }
        
        return $mdDom;
    }


    /** 
     * Parser the provided file and returns the corresponding DOM document.
     * 
     * @param string $mdFile
     * @throws Exception\FileNotFoundException
     * @return \DOMDocument
     */
    public function parseMetadataFile($mdFile)
    {
        $mdString = @file_get_contents($mdFile);
        if (false === $mdString) {
            throw new Exception\FileNotFoundException($mdFile);
        }
        
        return $this->parseMetadataString($mdString);
    }


    /**
     * Creates a new DOM document.
     * 
     * @return \DOMDocument
     */
    public function createNewDomDocument($version = '1.0', $encoding = 'utf-8')
    {
        return new DOMDocument($version, $encoding);
    }


    /**
     * Creates a new DOM document from the provided DOM node.
     * 
     * @param DOMNode $node
     * @return DOMDocument
     */
    public function createDocumentFromNode(DOMNode $node)
    {
        $dom = $this->createNewDomDocument();
        $dom->appendChild($dom->importNode($node, true));
        
        return $dom;
    }
}