<?php

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_blank",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/
if($_SESSION['utilisateurs_admin'] == 1){ // on affiche le menu de navigation pour les admins
    $page_nav = array(
        "dashboard" => array(
            "title" => "Tableau de bord",
            "icon" => "fa-tachometer",
            "url" => "index.php?p=modules/page_dashboard"
        ),
        "stages" => array(
            "title" => "Stages",
            "icon" => "fa-graduation-cap",
            "url" => "index.php?p=modules/page_stages",
        ),
        "formations" => array(
            "title" => "Formations",
            "icon" => "fa-tags",
            "url" => "index.php?p=modules/page_formations",
        ),
        "associations" => array(
            "title" => "Associations",
            "icon" => "fa-building",
            "url" => "index.php?p=modules/page_associations",
        ),
        "utilisateurs" => array(
            "title" => "Utilisateurs",
            "icon" => "fa-child",
            "url" => "index.php?p=modules/page_utilisateurs",
        ),
        "information" => array(
            "title" => "Informations",
            "icon" => "fa-info-circle",
            "url" => "",
        )
    );
} else { // pour les autres utilisateurs
    $page_nav = array(
        "stages" => array(
            "title" => "Stages",
            "icon" => "fa-graduation-cap",
            "url" => "index.php?p=modules/page_stages",
        ),
        "gerer" => array(
            "title" => "Gérer formation",
            "icon" => "fa-info-circle",
            "url" => "index.php?p=modules/page_gerer",
        )
    );
}


//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>