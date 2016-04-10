<?php require_once("./inc/init.php");

$associations_id = $_POST['id'];

$pdo->sql("DELETE FROM associations WHERE associations_id = ?", array($associations_id));

?>