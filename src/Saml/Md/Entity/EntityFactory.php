<?php

namespace Saml\Md\Entity;


class EntityFactory implements EntityFactoryInterface
{


    /**
     * {@inheritdoc}
     * @see \Saml\Md\Entity\EntityFactoryInterface::createEntity()
     */
    public function createEntity(\DOMDocument $entityDom)
    {
        return new Entity($entityDom);
    }
}