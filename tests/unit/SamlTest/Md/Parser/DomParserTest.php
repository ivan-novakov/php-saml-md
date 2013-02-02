<?php

namespace SamlTest\Md\Parser;

use Saml\Md\Parser\DomParser;


class DomParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DomParser
     */
    protected $parser = null;


    public function setUp()
    {
        $this->parser = new DomParser();
    }


    public function testParseMetadataString()
    {
        $dom = $this->parser->parseMetadataString($this->_getMetadataString());
        $this->assertInstanceOf('DomDocument', $dom);
    }


    public function testParseMetadataStringWithInvalidXml()
    {
        $this->setExpectedException('Saml\Md\Parser\Exception\XmlParseException');
        $dom = $this->parser->parseMetadataString('invalid XML');
    }


    public function testParseMetadataFile()
    {
        $dom = $this->parser->parseMetadataFile($this->_getMetadataFilename());
        $this->assertInstanceOf('DomDocument', $dom);
    }


    public function testParseMetadataFileWithInvalidFile()
    {
        $this->setExpectedException('Saml\Md\Parser\Exception\FileNotFoundException');
        $dom = $this->parser->parseMetadataFile('/some/invalid/file.xml');
    }


    public function testCreateNewDomDocument()
    {
        $this->assertInstanceOf('DomDocument', $this->parser->createNewDomDocument());
    }


    public function testCreateDocumentFromNode()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $node = $dom->appendChild($dom->createElement('foo', 'bar'));
        
        $this->assertInstanceOf('DOMDocument', $this->parser->createDocumentFromNode($node));
    }


    protected function _getMetadataString()
    {
        return file_get_contents($this->_getMetadataFilename());
    }


    protected function _getMetadataFilename()
    {
        return PHPSAMLMD_TESTS_DATA_DIR . '/metadata.xml';
    }
}