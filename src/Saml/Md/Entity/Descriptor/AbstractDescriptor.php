<?php

namespace Saml\Md\Entity\Descriptor;


class AbstractDescriptor
{

    /**
     * The descriptor element.
     * 
     * @var \DOMElement
     */
    protected $elm = null;

    /**
     * The original DOM document.
     * 
     * @var \DOMDocument
     */
    protected $dom = null;

    /**
     * The Xpath object for the DOM document.
     * 
     * @var \DOMXPath
     */
    protected $xpath = null;


    /**
     * Constructor.
     * 
     * @param \DOMElement $descriptorElement
     */
    public function __construct(\DOMElement $descriptorElement, \DOMDOcument $originalDom, \DOMXpath $xpath)
    {
        $this->elm = $descriptorElement;
        $this->dom = $originalDom;
        $this->xpath = $xpath;
    }


    public function getExtensions()
    {}


    public function getCertificates()
    {}


    public function getServices()
    {}
}