<?php

require_once('../../../lib/config.php');

/* données sur la formation */
$formation_id = $_POST['formations_id'];
$formations_intitule = $_POST['formations_intitule'];
$formations_domaine = $_POST['formations_domaine'];
$difficulte = $_POST['difficulte'];
$formations_contenu = $_POST['formations_contenu'];
/* données sur l'intervenant */
$intervenant_nom = $_POST['intervenant_nom'];
$intervenant_prenom = $_POST['intervenant_prenom'];
$intervenant_poste = $_POST['intervenant_poste'];
$intervenant_email = $_POST['intervenant_email'];

/* recuperation des anciennes doonées de la formation */
$formation_old = $pdo->sqlRow("SELECT * FROM formations WHERE formations_id = ?", array($formation_id));

/* update */
$pdo->sql("UPDATE `formations` SET 
            `domaines_id`= ?,
            `formations_intitule`= ?,
            `formations_niveau`= ?,
            `intervenants_nom`= ?,
            `intervenants_prenom`= ?,
            `intervenants_email`= ?,
            `intervenants_poste`= ?,
            `formations_contenu`= ? WHERE `formations_id`= ?", array($formations_domaine,
                                                                        $formations_intitule,
                                                                        $difficulte,
                                                                        $intervenant_nom,
                                                                        $intervenant_prenom,
                                                                        $intervenant_email,
                                                                        $intervenant_poste,
                                                                        $formations_contenu,
                                                                        $formation_id));
$alert = 'ok';

/* verification des doublons dans la bd */
$doublonsNom = $pdo->sql("SELECT formations_id FROM formations WHERE formations_intitule = ?", array($formations_intitule));
$countNom = $doublonsNom->rowCount();

if ($countNom > 1) {

    $alert = 'intitule'; // cas doublons association meme numero icom et meme nom

    $pdo->sql("UPDATE `formations` SET 
            `domaines_id`= ?,
            `formations_intitule`= ?,
            `formations_niveau`= ?,
            `intervenants_nom`= ?,
            `intervenants_prenom`= ?,
            `intervenants_email`= ?,
            `intervenants_poste`= ?,
            `formations_contenu`= ? WHERE `formations_id`= ?", array($formations_domaine,
                                                                        $formation_old['formations_intitule'],
                                                                        $difficulte,
                                                                        $intervenant_nom,
                                                                        $intervenant_prenom,
                                                                        $intervenant_email,
                                                                        $intervenant_poste,
                                                                        $formations_contenu,
                                                                        $formation_id));

}

echo json_encode(array('return' => $alert));

?>