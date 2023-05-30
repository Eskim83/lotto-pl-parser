<?php

	include_once 'db.php';
	
	$config = include_once('config.php');
	
	$db = new Db($config);
	$db->create();

?>