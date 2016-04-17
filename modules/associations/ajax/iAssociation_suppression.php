<?php

require_once('../../../lib/config.php');

$associations_id = $_POST['id'];

$pdo->sql("DELETE FROM associations WHERE associations_id = ?", array($associations_id));

?>