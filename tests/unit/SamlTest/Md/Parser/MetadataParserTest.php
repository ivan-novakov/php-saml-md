<?php

namespace SamlTest\Md\Parser;

use Saml\Md\Parser\MetadataParser;


class MetadataParserTest extends \PHPUnit_Framework_TestCase
{


    public function testParseDom()
    {
        $mdDom = new \DOMDocument();
        $mdDom->load(PHPSAMLMD_TESTS_DATA_DIR . '/metadata.xml');
        
        $parser = new MetadataParser();
        $collection = $parser->parseDom($mdDom);
        
        $this->assertInstanceOf('Saml\Md\Entity\Collection\Collection', $collection);
        $this->assertSame(2, $collection->count());
    }
}