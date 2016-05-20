<?php
/** Create with <3, plz take care :) **/
//configure constants
$directory = realpath(dirname(__FILE__));
$document_root = realpath($_SERVER['DOCUMENT_ROOT']);
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .
    $_SERVER['HTTP_HOST'];
if (strpos($directory, $document_root) === 0) {
    $base_url .= str_replace(DIRECTORY_SEPARATOR, '/', substr($directory, strlen($document_root)));
}

defined("APP_URL") ? null : define("APP_URL", str_replace("/lib", "", $base_url));
//Assets URL, location of your css, img, js, etc. files
defined("ASSETS_URL") ? null : define("ASSETS_URL", APP_URL);
$_SESSION['ASSETS_URL'] = ASSETS_URL;

// La version pour l'admin
defined("APP_URL_ADMIN") ? null : define("APP_URL_ADMIN", str_replace("/lib", "", $base_url) . "/admin_caso");
//Assets URL, location of your css, img, js, etc. files
defined("ASSETS_URL_ADMIN") ? null : define("ASSETS_URL_ADMIN", APP_URL_ADMIN);
$_SESSION['ASSETS_URL_ADMIN'] = ASSETS_URL_ADMIN;

//Infos connections


define('PDO_DSN', 'mysql:host=mysql.francois-garcia.ws;dbname=formadb');
define('PDO_USERNAME', 'fitchadmin');
define('PDO_PASSWORD', 'menphis31');

//require library files
require_once("func.global.php");

require_once("smartui/class.smartutil.php");
require_once("smartui/class.smartui.php");

// smart UI plugins
require_once("smartui/class.smartui-widget.php");
require_once("smartui/class.smartui-datatable.php");
require_once("smartui/class.smartui-button.php");
require_once("smartui/class.smartui-tab.php");
require_once("smartui/class.smartui-accordion.php");
require_once("smartui/class.smartui-carousel.php");
require_once("smartui/class.smartui-smartform.php");
require_once("smartui/class.smartui-nav.php");

SmartUI::$icon_source = 'fa';

// register our UI plugins
SmartUI::register('widget', 'Widget');
SmartUI::register('datatable', 'DataTable');
SmartUI::register('button', 'Button');
SmartUI::register('tab', 'Tab');
SmartUI::register('accordion', 'Accordion');
SmartUI::register('carousel', 'Carousel');
SmartUI::register('smartform', 'SmartForm');
SmartUI::register('nav', 'Nav');

require_once("class.html-indent.php");
require_once("class.parsedown.php");

require $directory . '/../vendor/autoload.php';
$pdo = new \BenTools\PDOExtended\PDOExtended(PDO_DSN, PDO_USERNAME, PDO_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
/*$phpmailer = new \PHPMailer\PHPMailer\PHPMailer();
$phpmailer->setLanguage('fr');
$phpmailer->CharSet = 'UTF-8';*/

$func = new Functions();


/***** Définition des variables de la date FR  ****/

setlocale(LC_TIME, 'fr_FR', 'fra');
date_default_timezone_set("Europe/Paris");
//Definit l'encodage interne
mb_internal_encoding("UTF-8");


/***** INFORMATIONS SERVEUR *****/

if (!defined('RACINE_SERVEUR')) define('RACINE_SERVEUR', __DIR__ . '/..');
define('CHEMIN_SERVEUR', APP_URL); //APP_URL ou http://xxxxxxxxxx.com

define('CHEMIN_IMAGES', '/assets/img/');
define('CHEMIN_FICHIERS', '/assets/img/transit');
define('CHEMIN_IMAGE', '/assets/img/transit/');
define('CHEMIN_AVATAR', '../../../assets/img/avatars/');

/***** INFORMATIONS GLOBALES *****/

define('IWIT_SYSTEMS', 'IWIT Systems');

/***** VARIABLES PAR DEFAUT *****/

$msg_ok = "";
$msg_erreur = "";
$msg_erreur_sql = "";


/***** MODE DÉBOGAGE *****/
$func->debug(1);

session_start();

?>
