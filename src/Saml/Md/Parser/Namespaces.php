<?php

namespace Saml\Md\Parser;


class Namespaces
{

    /**
     * SAML metadata namespaces
     *
     * @var array
     */
    protected static $metadataNamespaces = array(
        'md' => 'urn:oasis:names:tc:SAML:2.0:metadata',
        'xml' => 'http://www.w3.org/XML/1998/namespace',
        'ds' => 'http://www.w3.org/2000/09/xmldsig#',
        'xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'shibmd' => 'urn:mace:shibboleth:metadata:1.0',
        'mdui' => 'urn:oasis:names:tc:SAML:metadata:ui',
        'eduidmd' => 'http://eduid.cz/schema/metadata/1.0'
    );


    static public function getMetadataNamespaces()
    {
        return self::$metadataNamespaces;
    }
}