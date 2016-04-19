<?php

require_once('../../../lib/config.php');

/* recuperation de l'id de l'association à modifier */
$associations_id = $_POST['associations_id'];
/* informations association */
$associations_nom = $_POST['associations_nom'];
$associations_icom = $_POST['associations_icom'];
$associations_email = $_POST['associations_email'];
$utilisateurs_motDePasse = (empty($_POST['associations_motDePasse'])) ? $pdo->sqlValue("SELECT utilisateurs_motDePasse FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id)) : sha1($_POST['associations_motDePasse']); // cryptage du mot de passe pour renforcer la sécurité de la BD
/* information interlocuteur */
$associations_interlocuteur_nom = $_POST['associations_interlocuteur_nom'];
$associations_interlocuteur_prenom = $_POST['associations_interlocuteur_prenom'];
$associations_interlocuteur_telephone = $_POST['associations_interlocuteur_telephone'];
$associations_interlocuteur_fax = $_POST['associations_interlocuteur_fax'];

/* recuperation de l'ancien nom de l'association */
$associations_old = $pdo->sqlRow("SELECT * FROM associations WHERE associations_id = ?", array($associations_id));

$pdo->sql("UPDATE `associations` SET 
                `associations_nom`=?,
                `associations_numeroICOM`= ?,
                `associations_email`= ?,
                `associations_motDePasse`= ?,
                `associations_interlocuteur_nom`= ?,
                `associations_interlocuteur_prenom`= ?,
                `associations_interlocuteur_telephone`= ?,
                `associations_interlocuteur_fax`= ? WHERE `associations_id`= ?", array($associations_nom,
                                                                                       $associations_icom,
                                                                                       $associations_email,
                                                                                       $utilisateurs_motDePasse,
                                                                                       $associations_interlocuteur_nom,
                                                                                       $associations_interlocuteur_prenom,
                                                                                       $associations_interlocuteur_telephone,
                                                                                       $associations_interlocuteur_fax,
                                                                                       $associations_id));

/* verification des doublons dans la bd */
$doublonsNom = $pdo->sql("SELECT associations_id FROM associations WHERE associations_nom = ?", array($associations_nom));
$countNom = $doublonsNom->rowCount();

$doublonsIcom = $pdo->sql("SELECT associations_id FROM associations WHERE associations_numeroICOM = ?", array($associations_icom));
$countIcom = $doublonsIcom->rowCount();

if ($countNom > 1 && $countIcom > 1) {

    $alert = 'nom&icom'; // cas doublons association meme numero icom et meme nom

    $pdo->sql("UPDATE `associations` SET 
                `associations_nom`=?,
                `associations_numeroICOM`= ?,
                `associations_email`= ?,
                `associations_motDePasse`= ?,
                `associations_interlocuteur_nom`= ?,
                `associations_interlocuteur_prenom`= ?,
                `associations_interlocuteur_telephone`= ?,
                `associations_interlocuteur_fax`= ? WHERE `associations_id`= ?", array($associations_old['associations_nom'],
                                                                                       $associations_old['associations_numeroICOM'],
                                                                                       $associations_email,
                                                                                       $utilisateurs_motDePasse,
                                                                                       $associations_interlocuteur_nom,
                                                                                       $associations_interlocuteur_prenom,
                                                                                       $associations_interlocuteur_telephone,
                                                                                       $associations_interlocuteur_fax,
                                                                                       $associations_id));

} else if ($countNom > 1) {

    $alert = 'nom'; // cas doublons association au meme nom

    $pdo->sql("UPDATE `associations` SET 
                `associations_nom`=?,
                `associations_numeroICOM`= ?,
                `associations_email`= ?,
                `associations_motDePasse`= ?,
                `associations_interlocuteur_nom`= ?,
                `associations_interlocuteur_prenom`= ?,
                `associations_interlocuteur_telephone`= ?,
                `associations_interlocuteur_fax`= ? WHERE `associations_id`= ?", array($associations_old['associations_nom'],
                                                                                       $associations_icom,
                                                                                       $associations_email,
                                                                                       $utilisateurs_motDePasse,
                                                                                       $associations_interlocuteur_nom,
                                                                                       $associations_interlocuteur_prenom,
                                                                                       $associations_interlocuteur_telephone,
                                                                                       $associations_interlocuteur_fax,
                                                                                       $associations_id));
} else if ($countIcom > 1) {

    $alert = 'icom'; // cas doublons association meme numero icom

    $pdo->sql("UPDATE `associations` SET 
                `associations_nom`=?,
                `associations_numeroICOM`= ?,
                `associations_email`= ?,
                `associations_motDePasse`= ?,
                `associations_interlocuteur_nom`= ?,
                `associations_interlocuteur_prenom`= ?,
                `associations_interlocuteur_telephone`= ?,
                `associations_interlocuteur_fax`= ? WHERE `associations_id`= ?", array($associations_nom,
                                                                                       $associations_old['associations_numeroICOM'],
                                                                                       $associations_email,
                                                                                       $utilisateurs_motDePasse,
                                                                                       $associations_interlocuteur_nom,
                                                                                       $associations_interlocuteur_prenom,
                                                                                       $associations_interlocuteur_telephone,
                                                                                       $associations_interlocuteur_fax,
                                                                                       $associations_id));
}

echo json_encode(array('return' => $alert));

?>