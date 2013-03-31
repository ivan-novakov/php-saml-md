<?php

namespace Saml\Md\Entity;

use Saml\Md\Parser\Namespaces;

use Saml\Md\Parser\XpathFactory;


class Entity
{

    const ENTITY_ID = 'entityID';

    const SP_SSO_DESCRIPTOR = 'SPSSODescriptor';

    const IDP_SSO_DESCRIPTOR = 'IDPSSODescriptor';

    const TYPE_SP = 'sp';

    const TYPE_IDP = 'idp';

    /**
     * The DOM representation of the entity XML.
     *
     * @var \DOMDocument
     */
    protected $dom = null;

    /**
     * DOM XPath 
     * @var \DOMXPath
     */
    protected $xpath = null;

    /**
     * The Xpath factory.
     * 
     * @var XpathFactory
     */
    protected $xpathFactory = null;


    /**
     * Constructor.
     *
     * @param \DOMDocument $entityDom            
     */
    public function __construct(\DOMDocument $entityDom)
    {
        $this->dom = $entityDom;
    }


    /**
     * Sets the XPath factory.
     * 
     * @param XpathFactory $xpathFactory
     */
    public function setXpathFactory(XpathFactory $xpathFactory)
    {
        $this->xpathFactory = $xpathFactory;
    }


    /**
     * Returns the XPath factory.
     * 
     * @return XpathFactory
     */
    public function getXpathFactory()
    {
        if (! ($this->xpathFactory instanceof XpathFactory)) {
            $this->xpathFactory = new XpathFactory();
        }
        
        return $this->xpathFactory;
    }


    /**
     * Returns the entity ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->dom->documentElement->getAttribute(self::ENTITY_ID);
    }


    /**
     * Returns true, if the entity is an IdP entity.
     * FIXME - move to subclass
     * @return boolean
     */
    public function isIdp()
    {
        try {
            return ($this->getType() == self::TYPE_IDP);
        } catch (Exception\UnsupportedEntityTypeException $e) {
            return false;
        }
    }


    /**
     * Returns true if the entity is a SP entity.
     * FIXME - move to subclass
     * @return boolean
     */
    public function isSp()
    {
        try {
            return ($this->getType() == self::TYPE_SP);
        } catch (Exception\UnsupportedEntityTypeException $e) {
            return false;
        }
    }


    /**
     * Returns the entity type (SP or IdP).
     *
     * @throws Exception\UnsupportedEntityTypeException
     * @return string
     */
    public function getType()
    {
        $rootChildElementNames = $this->_getRootChildElementNames();
        
        if (in_array(self::SP_SSO_DESCRIPTOR, $rootChildElementNames)) {
            return self::TYPE_SP;
        }
        
        if (in_array(self::IDP_SSO_DESCRIPTOR, $rootChildElementNames)) {
            return self::TYPE_IDP;
        }
        
        throw new Exception\UnsupportedEntityTypeException();
    }


    /**
     * Returns organization info.
     * 
     * @return array
     */
    public function getOrganizationInfo()
    {
        $info = array();
        $node = $this->queryXpathSingleNode('/md:EntityDescriptor/md:Organization');
        if ($node) {
            foreach ($node->childNodes as $childNode) {
                if ($childNode->nodeType == XML_ELEMENT_NODE) {
                    $lang = $childNode->getAttributeNS(Namespaces::NS_XML, 'lang');
                    if ($lang) {
                        $info[$lang][$childNode->tagName] = $childNode->nodeValue;
                    }
                }
            }
        }
        
        return $info;
    }


    /**
     * Returns contact info.
     * 
     * @return array
     */
    public function getContactInfo()
    {
        $info = array();
        $nodeList = $this->queryXpath('/md:EntityDescriptor/md:ContactPerson');
        foreach ($nodeList as $node) {
            $contact = array();
            foreach ($node->childNodes as $childNode) {
                if ($childNode->nodeType == XML_ELEMENT_NODE) {
                    $contact['info'][$childNode->tagName] = $childNode->nodeValue;
                }
            }
            $contact['type'] = $node->getAttribute('contactType');
            $info[] = $contact;
        }
        
        return $info;
    }


    /**
     * Performs an XPath query.
     * 
     * @param string $xpathQuery
     * @return \DOMNodeList
     */
    public function queryXpath($xpathQuery)
    {
        return $this->getXpath()
            ->query($xpathQuery);
    }


    /**
     * Performs an XPath query and returns a single node.
     * 
     * @param string $xpathQuery
     * @return \DOMNode|null
     */
    public function queryXpathSingleNode($xpathQuery)
    {
        $nodeList = $this->queryXpath($xpathQuery);
        if ($nodeList->length) {
            return $nodeList->item(0);
        }
        
        return null;
    }


    /**
     * Returns the XPath object.
     * 
     * @return \DOMXPath
     */
    public function getXpath()
    {
        if (! ($this->xpath instanceof \DOMXPath)) {
            $this->xpath = $this->getXpathFactory()
                ->createXpath($this->dom);
        }
        
        return $this->xpath;
    }


    protected function _getRootChildElementNames()
    {
        $names = array();
        foreach ($this->dom->documentElement->childNodes as $childNode) {
            /* @var $childNode \DomNode */
            $names[] = $childNode->nodeName;
        }
        
        return $names;
    }
}