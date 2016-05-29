<?php

session_start();
require_once('../../../lib/config.php');

// informations association
$stages_formations_id = $_POST['stages_formations_id'];
$formations_id = $_POST['formations_id'];
$associations_id = $_SESSION['associations_id']; // on recupere l'association depuis $_SESSION
$salles_id = $_POST['salles_id'];
$stages_prix = $_POST['stages_prix'];
$stages_places = $_POST['stages_places'];
$stages_date = $func->dateUS($_POST['stages_date']);


$pdo->sql("UPDATE `stages_formations` SET
`formations_id`= $formations_id,
`associations_id`= $associations_id,
`salles_id`= $salles_id,
`stages_formations_prix`= $stages_prix,
`stages_formations_placeRestantes`= $stages_places,
`stages_formations_date`= ? WHERE `stages_formations_id`= $stages_formations_id", array($stages_date));

$alert = 'ok';
echo json_encode(array('return' => $alert));

?>