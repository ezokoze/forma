<?php

require_once('../../../lib/config.php');

$stages_id = $_POST['id'];

$pdo->sql("DELETE FROM stages_formations WHERE stages_formations_id = ?", array($stages_id));

?>