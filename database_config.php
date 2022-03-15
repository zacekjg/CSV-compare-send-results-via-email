<?php

$dsn = '';
$user = '';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo '<p>'.$e->getMessage().'</p>';
    exit;
}