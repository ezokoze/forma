<?php

require_once('../../../lib/config.php');

$pdo->sql("UPDATE `utilisateurs` SET `utilisateurs_quotaFormation` = ?", array('0'));

?>