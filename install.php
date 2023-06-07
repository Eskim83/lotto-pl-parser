<?php

/*
Autor: Maciej Włodarczak (https://eskim.pl)
Wersja: 1.0

Na podstawie artykułu: https://eskim.pl/skrypt-w-php-po-korzystajacy-z-bazy-sqlite/
*/

include_once 'db.php';

$config = include_once('config.php');

$db = new Db($config);
$db->create();

?>