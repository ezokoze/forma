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
$page_nav = array(
    "dashboard" => array(
        "title" => "Tableau de bord",
        "icon" => "fa-tachometer",
        "url" => "ajax/page_dashboard.php"
    ),
    "stages" => array(
        "title" => "Stages",
        "icon" => "fa-graduation-cap",
        "url" => "ajax/page_stages.php",
    ),
    "formations" => array(
        "title" => "Formations",
        "icon" => "fa-tags",
        "url" => "",
    ),
    "associations" => array(
        "title" => "Associations",
        "icon" => "fa-building",
        "url" => "ajax/page_associations.php",
    ),
    "utilisateurs" => array(
        "title" => "Utilisateurs",
        "icon" => "fa-child",
        "url" => "",
    ),
    "information" => array(
        "title" => "Informations",
        "icon" => "fa-info-circle",
        "url" => "",
    )

    /*"intervenants_lel" => array(
        "title" => "Intervenants",
        "icon" => "fa-code",
        "sub" => array(
            'listing_intervenants' => array(
                'title' => 'Listings',
                'url' => "ajax/smartui-alert.php"
            ),
            'progress' => array(
                'title' => 'Progress',
                'url' => 'ajax/smartui-progress.php'
            )
        ),
        "carousel" => array(
            "title" => "Carousel",
            "url" => 'ajax/smartui-carousel.php'
        ),
        "tab" => array(
            "title" => "Tab",
            "url" => 'ajax/smartui-tab.php'
        ),
        "accordion" => array(
            "title" => "Accordion",
            "url" => 'ajax/smartui-accordion.php'
        ),
        "widget" => array(
            'title' => "Widget",
            'url' => "ajax/smartui-widget.php"
        ),
        "datatable" => array(
            "title" => "DataTable",
            "url" => "ajax/smartui-datatable.php"
        ),
        "button" => array(
            "title" => "Button",
            "url" => "ajax/smartui-button.php"
        ),
        'smartform' => array(
            'title' => 'Smart Form',
            'url' => 'ajax/smartui-form.php'
        )
    )*/


);

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>