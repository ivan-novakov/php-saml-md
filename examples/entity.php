<?php

use Saml\Md\Entity\Entity;

require __DIR__ . '/_common.php';

$dom = new DOMDocument();
$dom->load(__DIR__ . '/../tests/data/idp-metadata.xml');

$entity = new Entity($dom);
_dump($entity->getContactInfo());
_dump($entity->getOrganizationInfo());