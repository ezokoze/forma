<?php

require_once('../../../lib/config.php');

// recuperation de l'id de l'utilisateur du modal de modification
$utilisateurs_id = $_POST['utilisateurs_id'];
// informations association
$associations_id = $_POST['associations_id'];
// information utilisateur
$utilisateurs_type = $_POST['utilisateurs_type'];
$utilisateurs_nom = $_POST['utilisateurs_nom'];
$utilisateurs_prenom = $_POST['utilisateurs_prenom'];
$utilisateurs_email = $_POST['utilisateurs_email'];
$utilisateurs_motDePasse = (empty($_POST['utilisateurs_motDePasse'])) ? $pdo->sqlValue("SELECT utilisateurs_motDePasse FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id)) : sha1($_POST['utilisateurs_motDePasse']); // cryptage du mot de passe pour renforcer la sécurité de la BD
$utilisateurs_avatar = $_FILES['utilisateurs_avatar'];

// utilisateur avant update
$utilisateurs_old = $pdo->sqlRow("SELECT * FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id));

if (!empty($utilisateurs_avatar)) {

    // upload d'un avatar pour l'utilisateur
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

    if ($retour_upload) { // si l'upload c'est bien déroulé

        $pdo->sql("UPDATE `utilisateurs` SET 
                        `utilisateurs_type`= '$utilisateurs_type',
                        `associations_id`= '$associations_id',
                        `utilisateurs_nom`= '$utilisateurs_nom',
                        `utilisateurs_prenom`= '$utilisateurs_prenom',
                        `utilisateurs_email`= '$utilisateurs_email',
                        `utilisateurs_motDePasse`= '$utilisateurs_motDePasse'
                        WHERE `utilisateurs_id`= '$utilisateurs_id' ");

        $img_url = '../../..' . CHEMIN_IMAGE . $upload['nom']; // chemin absolu vers l'image uploadé
        $avatar_url = CHEMIN_AVATAR . $utilisateurs_id . '.png'; // on specifie l'emplacement de l'ancienne image
        unlink($avatar_url); // on supprime l'ancienne image avant d'en créer une nouvelle

        try {
            $img = new \abeautifulsite\SimpleImage($img_url); // création de l'objet image
            $img->thumbnail(250, 250)->save($avatar_url); // trimage de l'image avec proportion de 250x250px
            unlink($img_url); // on supprime l'ancienne image uploadé dans 'transit'
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $alert = '';

    } else {
        $alert = 'avatar';
    }

    // à tester : $_SESSION['utilisateurs_image'] = $avatar_url;

} else { // si l'utilisateur n'a pas renseigné de nouvelle image

    $pdo->sql("UPDATE `utilisateurs` SET 
                        `utilisateurs_type`= '$utilisateurs_type',
                        `associations_id`= '$associations_id',
                        `utilisateurs_nom`= '$utilisateurs_nom',
                        `utilisateurs_prenom`= '$utilisateurs_prenom',
                        `utilisateurs_email`= '$utilisateurs_email',
                        `utilisateurs_motDePasse`= '$utilisateurs_motDePasse'
                        WHERE `utilisateurs_id`= '$utilisateurs_id' ");
}

// verification des doublons dans la bd
$doublonsEmail = $pdo->sql("SELECT utilisateurs_id FROM utilisateurs WHERE utilisateurs_email = ?", array($utilisateurs_email));
$countEmail = $doublonsEmail->rowCount();

// verification erreur
if ($countEmail > 1) {
    $alert = 'email'; // cas doublons email

    $pdo->sql("UPDATE `utilisateurs` SET 
                        `utilisateurs_type`= '$utilisateurs_type',
                        `associations_id`= '$associations_id',
                        `utilisateurs_nom`= '$utilisateurs_nom',
                        `utilisateurs_prenom`= '$utilisateurs_prenom',
                        `utilisateurs_email`= ?,
                        `utilisateurs_motDePasse`= '$utilisateurs_motDePasse'
                        WHERE `utilisateurs_id`= '$utilisateurs_id' ", array($utilisateurs_old['utilisateurs_email']));
}

echo json_encode(array('return' => $alert));

?>