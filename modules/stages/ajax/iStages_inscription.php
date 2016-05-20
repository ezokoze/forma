<?php

session_start();
require_once('../../../lib/config.php');

/* données sur l'inscription */
$stage_id = $_POST['stage_id'];
$utilisateurs_id = $_SESSION['utilisateurs_id'];

/* verification des doublons dans la bd */
$doublonsInscription = $pdo->sql("SELECT inscriptions_id FROM inscriptions WHERE stages_formations_id = ? AND utilisateurs_id = ?", array($stage_id, $utilisateurs_id));
$countInscription = $doublonsInscription->rowCount();

if ($countInscription >= 2) {
    $alert = 'limite'; // cas doublons icom
} else {
    $pdo->sql("INSERT INTO `inscriptions`(`inscriptions_id`, `stages_formations_id`, `utilisateurs_id`, `inscriptions_etat`) 
                VALUES (
                NULL,
                ?,
                ?,
                ?)", array($stage_id, $utilisateurs_id, 'en cours'));

    $alert = 'ok';

}

echo json_encode(array('return' => $alert));

?>



















