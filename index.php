<?php 
require_once("config.php");

$usuario = new Usuario();

$usuario->loadById(5);



// $usuario->setDeslogin("Professor");
// $usuario->setDessenha("@31dada");
// $usuario->update();
?>