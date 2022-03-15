<?php

require_once __DIR__ . '/csvPreparer.php';
require_once __DIR__ . '/csvComparer.php';

$url_csv = '';
$delimiter_csv = "|";

$local_csv = __DIR__ . '/local.csv';

$prepare_tday = new csvPreparer($url_csv, $delimiter_csv);
$prepare_yday = new csvPreparer($local_csv, $delimiter_csv);

$tags_csv = [
    "key0",
    "key1",
    "key2",
    "key3",
    "key4",
];
$csv_new = 'active';
$csv_del = 'inactive';
$status = "Active";
$compare = new csvComparer(
                                $prepare_yday->getArray(), 
                                $prepare_tday->getArray(), 
                                $tags_csv, 
                                $csv_new, 
                                $csv_del, 
                                $status
                                );
