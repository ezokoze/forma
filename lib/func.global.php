<?php

use BenTools\PDOExtended\PDOExtended;

/**
 * Class Functions
 */
class Functions
{
    private $_pdo;

    public function __construct()
    {
        $this->_pdo = new PDOExtended(PDO_DSN, PDO_USERNAME, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    /**
     * Converti les dates US en FR
     *
     * @param     $date
     * @param int $param
     *
     * @return string
     *
     * 0 - 15/10/2015
     * 1 - 15/10/2015 à 15h52
     * 2 - Jeudi 15 octobre 2015
     * 3 - Jeudi 15 octobre 2015 à 15h52
     * 4 - Octobre
     * 5 - 15 octobre 2015
     */
    public function dateFR($date, $param = 0)
    {
        if ($date != "0000-00-00" && $date != "0000-00-00 00:00:00") {
            switch ($param) {
                case 0:
                    return strftime('%d/%m/%Y', strtotime($date));
                    break;
                case 1:
                    return strftime('%d/%m/%Y à %H:%M', strtotime($date));
                    break;
                case 2:
                    $strDate = mb_convert_encoding('%A %d %B %Y', 'ISO-8859-9', 'UTF-8');

                    return ucfirst(iconv("ISO-8859-9", "UTF-8", strftime($strDate, strtotime($date))));
                    break;
                case 3:
                    $strDate = mb_convert_encoding('%A %d %B %Y à %Hh%M', 'ISO-8859-9', 'UTF-8');

                    return ucfirst(iconv("ISO-8859-9", "UTF-8", strftime($strDate, strtotime($date))));
                    break;
                case 4:
                    $strDate = mb_convert_encoding('%B', 'ISO-8859-9', 'UTF-8');

                    return ucfirst(iconv("ISO-8859-9", "UTF-8", strftime($strDate, strtotime($date))));
                    break;
                case 5:
                    $strDate = mb_convert_encoding('%d %B %Y', 'ISO-8859-9', 'UTF-8');

                    return ucfirst(iconv("ISO-8859-9", "UTF-8", strftime($strDate, strtotime($date))));
                    break;
                case 6:
                    $strDate = mb_convert_encoding('%H:%M', 'ISO-8859-9', 'UTF-8');

                    return ucfirst(iconv("ISO-8859-9", "UTF-8", strftime($strDate, strtotime($date))));
                    break;
                default:
                    return date('d/m/Y');
            }
        } else return "";
    }

    /**
     * La fonction darkroom() renomme et redimensionne les photos envoyées lors de l'ajout d'un objet.
     * @param $img String Chemin absolu de l'image d'origine.
     * @param $to String Chemin absolu de l'image générée (.jpg).
     * @param $width Int Largeur de l'image générée. Si 0, valeur calculée en fonction de $height.
     * @param $height Int Hauteur de l'image génétée. Si 0, valeur calculée en fonction de $width.
     * Si $height = 0 et $width = 0, dimensions conservées mais conversion en .jpg
     */
    public function darkroom($img, $to, $width, $height = 0, $useGD = TRUE){

        $dimensions = getimagesize($img);
        $ratio      = $dimensions[0] / $dimensions[1];

        // Calcul des dimensions si 0 passé en paramètre
        if($width == 0 && $height == 0){
            $width = $dimensions[0];
            $height = $dimensions[1];
        }elseif($height == 0){
            $height = round($width / $ratio);
        }elseif ($width == 0){
            $width = round($height * $ratio);
        }

        if($dimensions[0] > ($width / $height) * $dimensions[1]){
            $dimY = $height;
            $dimX = round($height * $dimensions[0] / $dimensions[1]);
            $decalX = ($dimX - $width) / 2;
            $decalY = 0;
        }
        if($dimensions[0] < ($width / $height) * $dimensions[1]){
            $dimX = $width;
            $dimY = round($width * $dimensions[1] / $dimensions[0]);
            $decalY = ($dimY - $height) / 2;
            $decalX = 0;
        }
        if($dimensions[0] == ($width / $height) * $dimensions[1]){
            $dimX = $width;
            $dimY = $height;
            $decalX = 0;
            $decalY = 0;
        }

        // Création de l'image avec la librairie GD
        if($useGD){
            $pattern = imagecreatetruecolor($width, $height);
            $type = mime_content_type($img);
            switch (substr($type, 6)) {
                case 'jpeg':
                    $image = imagecreatefromjpeg($img);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($img);
                    break;
                case 'png':
                    $image = imagecreatefrompng($img);
                    break;
            }
            imagecopyresampled($pattern, $image, 0, 0, 0, 0, $dimX, $dimY, $dimensions[0], $dimensions[1]);
            imagedestroy($image);
            imagejpeg($pattern, $to, 100);

            return TRUE;

            // Création de l'image avec ImageMagick
        }else{
            $cmd = '/usr/bin/convert -resize '.$dimX.'x'.$dimY.' "'.$img.'" "'.$dest.'"';
            shell_exec($cmd);

            $cmd = '/usr/bin/convert -gravity Center -quality '.self::$quality.' -crop '.$largeur.'x'.$hauteur.'+0+0 -page '.$largeur.'x'.$hauteur.' "'.$dest.'" "'.$dest.'"';
            shell_exec($cmd);
        }
        return TRUE;
    }

    /**
     * Converti les dates FR en US
     *
     * @param     $date
     * @param int $param
     *
     * @return string
     *
     * 0 - 2016-12-20
     * 1 - 2016-12-20 15:24:52 ou 2016-12-20 00:00:00
     */
    public function dateUS($date, $param = 0)
    {
        if ($date != "") {
            switch ($param) {
                case 0:
                    return date_format(date_create(str_replace('/', '-', $date)), 'Y-m-d');
                    break;
                case 1:
                    return date_format(date_create(str_replace('/', '-', $date)), 'Y-m-d H:i:s');
                    break;
                default:
                    return date_format(date_create(str_replace('/', '-', $date)), 'Y-m-d');
            }
        } else return "";
    }

    /**
     * @param int $debug
     *
     * @link https://secure.php.net/manual/fr/function.error-reporting.php
     */
    public function debug($debug = 0)
    {
        switch ($debug) {
            case 1:
                // Rapporte les erreurs d'exécution de script
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
                break;
            case 2:
                // Rapporter les E_NOTICE peut vous aider à améliorer vos scripts
                // (variables non initialisées, variables mal orthographiées..)
                error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
                break;
            case 3:
                // Reporte toutes les erreurs PHP
                error_reporting(-1);
                break;
            default:
                // Désactiver le rapport d'erreurs
                error_reporting(0);
        }
    }

    /**
     * set document type
     *
     * @param string $type type of document
     */
    public function set_content_type($type = 'application/json')
    {
        header('Content-Type: ' . $type);
    }

    /**
     * Print Log to the page
     *
     * @param      $type
     * @param bool $pre
     */
    public function plog($type, $pre = true)
    {
        $select_logs = $this->_pdo->sqlArray("SELECT * FROM logs WHERE logs_type = ? ORDER BY logs_dateC DESC", array($type));
        if (!empty($select_logs)) {
            foreach ($select_logs as $select_log) {
                $info = date('d/m/Y H:i:s', strtotime($select_log['logs_dateC'])) . " - " . $select_log['logs_type'] . " - " . $select_log['logs_requete'];
                echo $result = $pre ? "<pre>" . $info . "</pre>" : $info;
            }
        }
    }

    /**
     * Log to BDD
     *
     * @param $type
     * @param $requete
     * @param $repertoire
     * @param $commentaire
     *
     * $func->elog("UPDATE", $insert_articles->debug()->preview(), realpath(dirname(__FILE__))."\\".basename(__FILE__, ".php").".php");
     */
    public function elog($type, $requete, $repertoire, $commentaire = "")
    {
        $this->_pdo->sql("INSERT INTO logs (logs_dateC, utilisateurs_id, logs_type, logs_requete, logs_repertoire, logs_commentaire, logs_ip) VALUES (NOW(),?,?,?,?,?,?)", array(
            $this->prevInsertBDD($_SESSION['utilisateur']['id']),
            $type,
            $requete,
            $repertoire,
            $commentaire,
            $this->get_ip_address()
        ));
    }

    /**
     * Formate la chaine lors d'une insertion en BDD
     *
     * @param $var
     *
     * @return string
     */
    public function prevInsertBDD($var)
    {
        return (!empty($var)) ? $var : "";
    }

    /**
     * Fonction redimensionnement et enregistrement copie d'image
     *
     * @param        $file
     * @param        $rep
     * @param        $largeur
     * @param        $hauteur
     * @param string $prefixe
     * @param string $type
     */
    public function resize($file, $rep, $largeur, $hauteur, $prefixe = "", $type = "jpg")
    {
        $truc = $rep . $file;
        $size = getimagesize($truc);

        $src_w = $size[0];
        $src_h = $size[1];

        if ($hauteur == 0) $hauteur = ($src_h * $largeur) / $src_w;

        if ($src_w > $src_h) {
            //plus large
            $dest_w = $largeur;
            $hauteur = ($src_h * $largeur) / $src_w;
            $dest_h = $hauteur;
        } else {
            //plus haut
            $largeur = ($hauteur * $src_w) / $src_h;
            $dest_w = $largeur;
            $dest_h = $hauteur;
        }

        switch ($type) {
            case "jpeg" :
            case "jpg" :
            case IMAGETYPE_JPEG :
                $src_img = imagecreatefromjpeg($truc);
                break;
            case "png" :
            case IMAGETYPE_PNG :
                $src_img = imagecreatefrompng($truc);
                break;
            case IMAGETYPE_GIF :
            case "gif" :
                $src_img = imagecreatefromgif($truc);
                break;
            default :
                $src_img = imagecreatefromjpeg($truc);
        }

        $dst_img = imagecreatetruecolor($dest_w, $dest_h);

        $a1 = 0;
        $a2 = $size[1] / 2 - 75;
        $dst_img = imagecreatetruecolor($dest_w, $dest_h);
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_w, $dest_h, $src_w, $src_h);

        imagejpeg($dst_img, $rep . $prefixe . $file, 75);
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }

    /**
     * Normalisation des noms de fichiers ou autre...
     *
     * @param $string
     *
     * @return mixed|string
     */
    public function normalize($string)
    {
        //$string = utf8_encode($string);
        $string = trim($string);
        $string = str_replace('\'', '_', $string);
        $string = str_replace(' ', '_', $string);
        $string = str_replace('\' ', '_', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace('\'', '_', $string);
        $string = str_replace('°', '_', $string);

        $translit = array('Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ã' => 'A', 'Å' => 'A', 'Ç' => 'C', 'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Ì' => 'I', 'Ñ' => 'N', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Õ' => 'O', 'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a', 'ç' => 'c', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o', 'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y');
        $string = strtr($string, $translit);
        //$string = strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $string = mb_strtolower($string);

        return $string;
    }

    /**
     * Ré-arrange plusieurs champs $_FILES en un tableau
     *
     * @param $file_post
     *
     * @return array
     */
    public function reArrayFiles(&$file_post)
    {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }

    /**
     * @param $fichier
     * @param $infos
     *
     * @return array
     */
    public function ajouter_fichier($fichier, $infos, $resize, $width_p, $height_p)
    {
        // Nom de l'entité si présent.
        $entite = (!empty($infos['entite'])) ? " (" . $infos['entite'] . ") " : "";

        // Si le fichier n'est pas vide
        if ($fichier['size'] > 0) {

            // Si le fichier doit être une image ou un fichier ?
            if ($infos['image']) {
                // Si le fichier est une image
                // GIF, JPEG, PNG, SWF, PSD, BMP, TIFF_II, TIFF_MM, JPC, JP2, JPX, JB2, SWC, IFF, WBMP, XBM et ICO.
                if (exif_imagetype($fichier['tmp_name'])) {
                    $fichierValide = true;
                } else {
                    $fichierValide = false;
                }
            } else {
                $fichierValide = true;
            }

            // Si le fichier est valide
            if ($fichierValide) {

                // Gestion du nom du fichier
                if (empty($infos['nom'])) {
                    $nom = $this->normalize(str_replace('\'', ' ', pathinfo($fichier['name'], PATHINFO_FILENAME)));
                } else {
                    $nom = $this->normalize(str_replace('\'', ' ', $infos['nom']));
                }


                // Je récupère l'extention du fichier
                $extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);

                // Répertoire de destination du fichier
                $destination = RACINE_SERVEUR . CHEMIN_FICHIERS . $infos['dossier'] . "/";

                // Si le dossier n'existe pas, je le crée.
                if (!is_dir($destination)) {
                    mkdir($destination, 0777);
                }

                $destinationComplete = $destination . $nom . "." . $extension;


                // Execution de l'upload !
                if (move_uploaded_file($fichier['tmp_name'], $destinationComplete)) {
                    $retour = array(
                        "retour" => true,
                        "message" => "l'upload du fichier a été réalisé avec succès" . $entite,
                        "nom" => $nom . "." . $extension
                    );
                    if($resize){
                        $this->darkroom($destinationComplete, $destinationComplete, $width_p);
                    }
                } else {
                    $retour = array(
                        "retour" => false,
                        "message" => "Une erreur s'est produite lors de l'upload du fichier" . $entite
                    );
                }

            } else {
                $retour = array(
                    "retour" => false,
                    "message" => "Ce fichier n'est pas une image" . $entite
                );
            }
        } else {
            $retour = array(
                "retour" => false,
                "message" => "Le fichier est vide" . $entite
            );
        }

        return $retour;
    }

    /**
     * Récupère l'addresse IP du client
     *
     * @return string
     */
    public
    function get_ip_address()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && ip2long($_SERVER["HTTP_X_FORWARDED_FOR"]) !== false) {
                $ipadres = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER["HTTP_CLIENT_IP"]) && ip2long($_SERVER["HTTP_CLIENT_IP"]) !== false) {
                $ipadres = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $ipadres = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR') && ip2long(getenv('HTTP_X_FORWARDED_FOR')) !== false) {
                $ipadres = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP') && ip2long(getenv('HTTP_CLIENT_IP')) !== false) {
                $ipadres = getenv('HTTP_CLIENT_IP');
            } else {
                $ipadres = getenv('REMOTE_ADDR');
            }
        }

        return $ipadres;
    }
}