<?php

//initialize the page
require_once("inc/init.php");

// si l'utilisateur n'est pas connecté le rediriger vers la page de login
if (!isset($_SESSION['utilisateurs_id'])) {
    header("Location: login.php?etat=disconnect");
}

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Iwit Steward";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//follow the tree in inc/config.ui.php
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
<div id="content">

	<?php
	if(!empty($_GET['p']))
	{
		include_once $_GET['p'].'.php';
	} else {
		include_once ('modules/locaux.php');
	}

	?>

</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	include("inc/footer.php");

	//include required scripts
	include("inc/scripts.php");

	//include footer
	include("inc/google-analytics.php");
