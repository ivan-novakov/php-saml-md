<?php

namespace Saml\Md\Entity;


interface EntityFactoryInterface
{


    /**
     * Creates a new entity instance.
     * 
     * @param \DOMDocument $entityDom
     * @return Entity
     */
    public function createEntity(\DOMDocument $entityDom);
}