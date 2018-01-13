<?php 
require_once("config.php");

$user = new Usuario();

$user->login("admin", "admin");

echo $user;

?>