<?php require_once("inc/init.php"); $func = new Functions();

/* informations association*/
$associations_nom = $_POST['associations_nom'];
$associations_icom = $_POST['associations_icom'];
$associations_email = $_POST['associations_email'];
$associations_motDePasse = $_POST['associations_motDePasse'];
/* information interlocuteur*/
$associations_interlocuteur_nom = $_POST['associations_interlocuteur_nom'];
$associations_interlocuteur_prenom = $_POST['associations_interlocuteur_prenom'];
$associations_interlocuteur_telephone = $_POST['associations_interlocuteur_telephone'];
$associations_interlocuteur_fax = $_POST['associations_interlocuteur_fax'];

/* verification des doublons dans la bd */
$doublonsIcom = $pdo->sql("SELECT associations_id FROM associations WHERE associations_numeroICOM = ?", array($associations_icom));
$countIcom = $doublonsIcom->rowCount();

$doublonsNom = $pdo->sql("SELECT associations_id FROM associations WHERE associations_nom = ?", array($associations_nom));
$countNom = $doublonsNom->rowCount();

if ($countIcom != 0) {
    $alert = 'icom'; // cas doublons icom
} else if ($doublonsNom != 0){
    $alert = 'nom'; // cas doublons nom
} else {
    $pdo->sql("INSERT INTO `associations`(
                `associations_id`, 
                `associations_numeroICOM`, 
                `associations_nom`, 
                `associations_interlocuteur_nom`, 
                `associations_interlocuteur_prenom`, 
                `associations_interlocuteur_email`, 
                `associations_interlocuteur_telephone`, 
                `associations_interlocuteur_fax`, 
                `associations_inscription`, 
                `associations_motDePasse`) 
                VALUES (
                [value-1],
                [value-2],
                [value-3],
                [value-4],
                [value-5],
                [value-6],
                [value-7],
                [value-8],
                [value-9],
                [value-10])",array());
}

echo json_encode(array('return' => $alert));

?>