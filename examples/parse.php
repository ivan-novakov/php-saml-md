<?php

use Saml\Md\Parser\Parser;

require __DIR__ . '/_common.php';

$mdFile = __DIR__ . '/data/eduid-metadata.xml';

$parser = new Parser();

$collection = $parser->parseFile($mdFile);

foreach ($collection as $entityId => $entity) {
    _dump($entityId);
    _dump($entity->getId());
}