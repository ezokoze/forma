<?php

require_once('../../lib/config.php');

$login = $_POST['email'];
$password = sha1($_POST['password']);

$utilisateurExiste = $pdo->sql("SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_email = ? AND utilisateurs_motDePasse = ?", array($login, $password));
$countUtilisateurs = $utilisateurExiste->rowCount();

if ($countUtilisateurs == 1) {

    // demarage de la session
    session_start();

    // remplissage des variables de session en fonction des données de l'utilisateur
    $allUtilsateur = $pdo->sqlRow("SELECT * FROM utilisateurs WHERE utilisateurs_email = ? AND utilisateurs_motDePasse = ?", array($login, $password));
    $_SESSION['utilisateurs_id'] = $allUtilsateur['utilisateurs_id'];
    $_SESSION['utilisateurs_type'] = $allUtilsateur['utilisateurs_type'];
    $_SESSION['associations_id'] = $allUtilsateur['associations_id'];
    $_SESSION['utilisateurs_nom'] = $allUtilsateur['utilisateurs_nom'];
    $_SESSION['utilisateurs_prenom'] = $allUtilsateur['utilisateurs_prenom'];
    $_SESSION['utilisateurs_email'] = $allUtilsateur['utilisateurs_email'];
    $_SESSION['utilisateurs_motDePasse'] = $allUtilsateur['utilisateurs_motDePasse'];
    $_SESSION['utilisateurs_image'] = $allUtilsateur['utilisateurs_image'];
    $_SESSION['utilisateurs_premierStage'] = $allUtilsateur['utilisateurs_premierStage'];
    $_SESSION['utilisateurs_quotaFormation'] = $allUtilsateur['utilisateurs_quotaFormation'];

    // redirection vers la page d'accueil
    header("Location: ../../index.php?p=modules/page_associations");

} else {
    echo 'you$uck';
}

?>