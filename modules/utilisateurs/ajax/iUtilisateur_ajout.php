<?php

require_once('../../../lib/config.php');

// informations association
$associations_id = $_POST['associations_id'];
// information utilisateur
$utilisateurs_type = $_POST['utilisateurs_type'];
$utilisateurs_nom = $_POST['utilisateurs_nom'];
$utilisateurs_prenom = $_POST['utilisateurs_prenom'];
$utilisateurs_email = $_POST['utilisateurs_email'];
$utilisateurs_motDePasse = sha1($_POST['utilisateurs_motDePasse']); // cryptage du mot de passe pour renforcer la sécurité de la BD
$utilisateurs_avatar = $_FILES['utilisateurs_avatar'];

// equivalent d'un lastInsertId mais en avance
$utilisateurs_avatar_name = $pdo->sqlValue("SELECT MAX(utilisateurs_id) FROM utilisateurs") + 1;

// verification des doublons dans la bd
$doublonsEmail = $pdo->sql("SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_email = ?", array($utilisateurs_email));
$countEmail = $doublonsEmail->rowCount();

// verification erreur
if ($countEmail != 0) {
    $alert = 'email'; // cas doublons email
} else {

    /// upload d'un avatar pour l'utilisateur
    $upload = $func->ajouter_fichier($utilisateurs_avatar, array(
        "dossier" => '',
        "nom" => false,
        "image" => true,
        "entite" => "Produit"
    ));

    if ($upload['retour']) {
        $retour_upload = true;
    } else {
        $retour_upload = false;
    }

    if($retour_upload) {
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
                ?,
                NULL,
                '')", array($utilisateurs_type, $associations_id, $utilisateurs_nom, $utilisateurs_prenom, $utilisateurs_email, $utilisateurs_motDePasse, ("/assets/img/avatars/" . $utilisateurs_avatar_name . '.png')));

        $img_url = '../../..' . CHEMIN_IMAGE . $upload['nom']; // chemin absolu vers l'image uploadé

        try {
            $img = new \abeautifulsite\SimpleImage($img_url); // création de l'objet image
            $img->thumbnail(250, 250)->save(CHEMIN_AVATAR . $utilisateurs_avatar_name . '.png'); // trimage de l'image avec proportion de 250x250
            unlink($img_url); // on supprime l'ancienne image uploadé dans 'transit'
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $alert = '';
    } else {
        $alert = 'avatar';
    }

}

echo json_encode(array('return' => $alert));

?>