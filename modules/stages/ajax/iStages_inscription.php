<?php

session_start();
require_once('../../../lib/config.php');

/* données sur l'inscription */
$stage_id = $_POST['stage_id'];
$utilisateurs_id = $_SESSION['utilisateurs_id'];

/* verification des doublons dans la bd */
$doublonsInscription = $pdo->sql("SELECT inscriptions_id FROM inscriptions WHERE stages_formations_id = ? AND utilisateurs_id = ?", array($stage_id, $utilisateurs_id));
$countInscription = $doublonsInscription->rowCount();
$nombrePlaceApresInscription = $pdo->sqlValue("SELECT stages_formations_placeRestantes FROM stages_formations WHERE stages_formations_id = ?", array($stage_id)) - 1;
/* mise a jour du quota d'inscription utilisateur*/
$quotaUtilisateur = $pdo->sqlValue("SELECT utilisateurs_quotaFormation FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id));

if ($countInscription >= 1 || $quotaUtilisateur >= 2) {
    $alert = 'limite'; // cas doublons inscription
} else {

    $alert = 'ok';

    $pdo->sql("INSERT INTO `inscriptions`(`inscriptions_id`, `stages_formations_id`, `utilisateurs_id`, `inscriptions_etat`) 
                VALUES (
                NULL,
                ?,
                ?,
                ?)", array($stage_id, $utilisateurs_id, 'en cours'));

    // on incrémente le quota de l'utilisateur
    $quotaUtilisateur = $quotaUtilisateur + 1;
    $pdo->sql("UPDATE utilisateurs SET utilisateurs_quotaFormation = ? WHERE utilisateurs_id = ?", array($quotaUtilisateur, $utilisateurs_id));
    // changement du nombre de place
    $nombrePlaceApresInscription = $pdo->sqlValue("SELECT stages_formations_placeRestantes FROM stages_formations WHERE stages_formations_id = ?", array($stage_id)) - 1;
    $pdo->sql("UPDATE stages_formations SET stages_formations_placeRestantes = ? WHERE stages_formations_id = ?", array($nombrePlaceApresInscription, $stage_id));
}

echo json_encode(array('return' => $alert));

?>



















