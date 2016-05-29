<?php

require_once('../../../lib/config.php');

$stages_formations_id = $_POST['stages_formations_id'];

// valeur anterieur du quota de l'utilisateur
$quota = $pdo->sqlValue("SELECT utilisateurs_quotaFormation FROM utilisateurs WHERE utilisateurs_id = ?", array($_SESSION['utilisateurs_id'])) - 1;

$pdo->sql("DELETE FROM inscriptions WHERE stages_formations_id = ?", array($stages_formations_id));
$pdo->sql("UPDATE `utilisateurs` SET `utilisateurs_quotaFormation`= ? WHERE `utilisateurs_id`= ?", array($quota, $_SESSION['utilisateurs_id']));

// changement nombre de place
$nombrePlaceApresDesinscription = $pdo->sqlValue("SELECT stages_formations_placeRestantes FROM stages_formations WHERE stages_formations_id = ?", array($stages_formations_id)) + 1;
$pdo->sql("UPDATE stages_formations SET stages_formations_placeRestantes = ? WHERE stages_formations_id = ?", array($nombrePlaceApresDesinscription, $stages_formations_id));

?>