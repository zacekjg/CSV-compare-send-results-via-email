<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/compare.php';
require_once __DIR__ . '/Mailer.php';
require __DIR__ . '/functions.php';

include __DIR__ . '/send_mail.php';
include __DIR__ . '/database_config.php';

$entity_type = 'Entity Type 1';
insertToDB($db, $compare, $entity_type);

$file = __DIR__ . '/local.csv';
$url_csv = '';
$current = file_get_contents($url_csv);
file_put_contents($file, $current);