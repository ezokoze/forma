<?php require_once("./inc/init.php");

$utilisateurs_id = $_POST['id'];

$pdo->sql("DELETE FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id));

?>