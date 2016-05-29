<?php

session_start();
require_once('../../../lib/config.php');

// informations association
$formations_id = $_POST['formations_id'];
$associations_id = $_POST['associations_id']; // on recupere l'association depuis $_SESSION
$salles_id = $_POST['salles_id'];
$stages_prix = $_POST['stages_prix'];
$stages_places = $_POST['stages_places'];
$stages_dateDebut = $func->dateUS($_POST['stages_dateDebut']);
$stages_dateFin = $func->dateUS($_POST['stages_dateFin']);
$stages_dateLimite = $func->dateUS($_POST['stages_dateLimite']);

$pdo->sql("INSERT INTO `stages_formations`
(`stages_formations_id`, 
`formations_id`, 
`associations_id`, 
`salles_id`, 
`stages_formations_prix`, 
`stages_formations_placeRestantes`, 
`stages_formations_dateDebut`,
`stages_formations_dateFin`,
`stages_formations_dateLimite`) VALUES (
    NULL,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?)", array($formations_id, $associations_id, $salles_id, $stages_prix, $stages_places, $stages_dateDebut, $stages_dateFin, $stages_dateLimite));

$alert = 'ok';
echo json_encode(array('return' => $alert));

?>