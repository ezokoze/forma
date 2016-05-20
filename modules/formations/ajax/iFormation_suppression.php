<?php

require_once('../../../lib/config.php');

$formationId = $_POST['id'];

$pdo->sql("DELETE FROM formations WHERE formations_id= ?", array($formationId));

?>