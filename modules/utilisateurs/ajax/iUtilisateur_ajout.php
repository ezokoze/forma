<?php

require_once('../../../lib/config.php');

/* informations association */
$associations_id = $_POST['associations_id'];
/* information utilisateur */
$utilisateurs_type = $_POST['utilisateurs_type'];
$utilisateurs_nom = $_POST['utilisateurs_nom'];
$utilisateurs_prenom = $_POST['utilisateurs_prenom'];
$utilisateurs_email = $_POST['utilisateurs_email'];
$utilisateurs_motDePasse = sha1($_POST['utilisateurs_motDePasse']);

/* verification des doublons dans la bd */
$doublonsEmail = $pdo->sql("SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_email = ?", array($utilisateurs_email));
$countEmail = $doublonsEmail->rowCount();

if ($countEmail != 0) {
    $alert = 'email'; // cas doublons email
} else {
    $pdo->sql("INSERT INTO `utilisateurs`(
                `utilisateurs_id`, 
                `utilisateurs_type`, 
                `association_id`, 
                `utilisateurs_nom`, 
                `utilisateurs_prenom`, 
                `utilisateurs_email`, 
                `utilisateurs_motDePasse`, 
                `utilisateurs_image`, 
                `utilisateurs_premierStage`, 
                `utilisateurs_quotaFormation`) 
                VALUES (
                NULL,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                'image',
                NULL,
                '')", array($utilisateurs_type, $associations_id,$utilisateurs_nom,$utilisateurs_prenom,$utilisateurs_email,$utilisateurs_motDePasse));

    $alert = 'ok';
}

echo json_encode(array('return' => $alert));

?>