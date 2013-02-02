<?php

namespace Saml\Md\Entity;


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
    protected $_dom = null;


    /**
     * Constructor.
     *
     * @param \DOMDocument $entityDom            
     */
    public function __construct (\DOMDocument $entityDom)
    {
        $this->_dom = $entityDom;
    }


    /**
     * Returns the entity ID.
     *
     * @return string
     */
    public function getId ()
    {
        return $this->_dom->documentElement->getAttribute(self::ENTITY_ID);
    }


    /**
     * Returns true, if the entity is an IdP entity.
     * FIXME - move to subclass
     * @return boolean
     */
    public function isIdp ()
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
    public function isSp ()
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
    public function getType ()
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


    protected function _getRootChildElementNames ()
    {
        $names = array();
        foreach ($this->_dom->documentElement->childNodes as $childNode) {
            /* @var $childNode \DomNode */
            $names[] = $childNode->nodeName;
        }
        
        return $names;
    }
}