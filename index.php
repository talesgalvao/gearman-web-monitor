<?php
ini_set('display_errors', '1');
require_once("bootstrap.php");

$loadClass = new load();
$loadClass->loader($_SERVER['REQUEST_URI']);