<?php

use Saml\Md\Parser\MetadataParser;

require __DIR__ . '/_common.php';

$mdFile = __DIR__ . '/data/eduid-metadata.xml';

$parser = new MetadataParser();

$collection = $parser->parseFile($mdFile);

foreach ($collection as $entityId => $entity) {
    _dump($entityId);
    _dump($entity->getId());
}