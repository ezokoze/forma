<?php

require_once('../../../lib/config.php');

/* données sur la formation */
$formations_intitule = $_POST['formations_intitule'];
$formations_domaine = $_POST['formations_domaine'];
$difficulte = $_POST['difficulte'];
$formations_contenu = $_POST['formations_contenu'];
 /* données sur l'intervenant & lieu */
$intervenant_nom = $_POST['intervenant_nom'];
$intervenant_prenom = $_POST['intervenant_prenom'];
$intervenant_poste = $_POST['intervenant_poste'];
$intervenant_email = $_POST['intervenant_email'];

/* verification des doublons dans la bd */
$doublonsFormation = $pdo->sql("SELECT formations_id FROM formations WHERE formations_intitule = ? AND domaines_id = ?", array($formations_intitule, $formations_domaine));
$countFormation = $doublonsFormation->rowCount();


if ($countFormation != 0) {
    $alert = 'formation'; // cas doublons icom
} else {
    $pdo->sql("INSERT INTO `formations`(
                                        `formations_id`, 
                                        `domaines_id`,
                                        `formations_intitule`, 
                                        `formations_niveau`, 
                                        `intervenants_nom`, 
                                        `intervenants_prenom`, 
                                        `intervenants_email`, 
                                        `intervenants_poste`, 
                                        `formations_contenu`) 
                                        VALUES (NULL,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                ?)", array($formations_domaine,
                                                           $formations_intitule,
                                                           $difficulte,
                                                           $intervenant_nom,
                                                           $intervenant_prenom,
                                                           $intervenant_email,
                                                           $intervenant_poste,
                                                           $formations_contenu));

    $alert = 'ok';

}

echo json_encode(array('return' => $alert));

?>



















