<?php

namespace Saml\Md\KeyDescriptor;


class KeyDescriptorFactory
{


    public function create()
    {
        return new KeyDescriptor();
    }


    public function createFromDomNode(\DomNode $domNode)
    {}
}