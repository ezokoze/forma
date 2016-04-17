<!DOCTYPE html>

<html lang="en-us" <?php echo implode(' ', array_map(function ($prop, $value) {
    return $prop . '="' . $value . '"';
}, array_keys($page_html_prop), $page_html_prop)); ?>>
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title> <?php echo $page_title != "" ? $page_title . " - " : ""; ?>SmartAdmin </title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen"
          href="<?php echo ASSETS_URL; ?>/assets/css/font-awesome.min.css">

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen"
          href="<?php echo ASSETS_URL; ?>/assets/css/smartadmin-production-plugins.min.css">
    <link rel="stylesheet" type="text/css" media="screen"
          href="<?php echo ASSETS_URL; ?>/assets/css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen"
          href="<?php echo ASSETS_URL; ?>/assets/css/smartadmin-skins.min.css">

    <!-- SmartAdmin RTL Support is under construction-->
    <link rel="stylesheet" type="text/css" media="screen"
          href="<?php echo ASSETS_URL; ?>/assets/css/smartadmin-rtl.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/assets/css/your_style.css">
    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update. -->

    <?php

    if ($page_css) {
        foreach ($page_css as $css) {
            echo '<link rel="stylesheet" type="text/css" media="screen" href="' . ASSETS_URL . '/assets/css/' . $css . '">';
        }
    }
    ?>


    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/assets/css/demo.min.css">

    <!-- FAVICONS -->
    <link rel="shortcut icon" href="<?php echo ASSETS_URL; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo ASSETS_URL; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>/assets/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSETS_URL; ?>/assets/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120"
          href="<?php echo ASSETS_URL; ?>/assets/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152"
          href="<?php echo ASSETS_URL; ?>/assets/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/assets/img/splash/ipad-landscape.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/assets/img/splash/ipad-portrait.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/assets/img/splash/iphone.png"
          media="screen and (max-device-width: 320px)">

    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        if (!window.jQuery) {
            document.write('<script src="<?php echo ASSETS_URL; ?>/assets/js/libs/jquery-2.1.1.min.js"><\/script>');
        }
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
        if (!window.jQuery.ui) {
            document.write('<script src="<?php echo ASSETS_URL; ?>/assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
        }
    </script>


</head>
<body class="smart-style-1" <?php echo implode(' ', array_map(function ($prop, $value) {
    return $prop . '="' . $value . '"';
}, array_keys($page_body_prop), $page_body_prop)); ?>>

<!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
     You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
<?php
if (!$no_main_header) {

    ?>
    <!-- HEADER -->
    <header id="header">
        <div id="logo-group">

            <!-- PLACE YOUR LOGO HERE -->
            <span id="logo"> <img src="<?php echo ASSETS_URL; ?>/assets/img/logo.png" alt="SmartAdmin"> </span>
            <!-- END LOGO PLACEHOLDER -->

            <!-- Note: The activity badge color changes when clicked and resets the number to 0
            Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
            <!--<span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>-->

            <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
            <div class="ajax-dropdown">

                <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="<?php echo APP_URL; ?>/assets/ajax/notify/mail.php">
                        Msgs (14) </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity"
                               id="<?php echo APP_URL; ?>/assets/ajax/notify/notifications.php">
                        notify (3) </label>
                    <label class="btn btn-default">
                        <input type="radio" name="activity" id="<?php echo APP_URL; ?>/assets/ajax/notify/tasks.php">
                        Tasks (4) </label>
                </div>

                <!-- notification content -->
                <div class="ajax-notifications custom-scroll">

                    <div class="alert alert-transparent">
                        <h4>Click a button to show messages here</h4>
                        This blank page message helps protect your privacy, or you can show the first message here
                        automatically.
                    </div>

                    <i class="fa fa-lock fa-4x fa-border"></i>

                </div>
                <!-- end notification content -->

                <!-- footer: refresh area -->
							<span> Last updated on: 12/12/2013 9:43AM
								<button type="button"
                                        data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..."
                                        class="btn btn-xs btn-default pull-right">
                                    <i class="fa fa-refresh"></i>
                                </button> </span>
                <!-- end footer -->

            </div>
            <!-- END AJAX-DROPDOWN -->
        </div>

        <!-- pulled right: nav area -->
        <div class="pull-right">

            <!-- collapse menu button -->
            <div id="hide-menu" class="btn-header pull-right">
                <span> <a href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i
                            class="fa fa-reorder"></i></a> </span>
            </div>
            <!-- end collapse menu -->

            <!-- #MOBILE -->
            <!-- Top menu profile link : this shows only when top menu is active -->
            <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
                <li class="">
                    <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                        <img src="<?php echo ASSETS_URL; ?>/assets/img/avatars/sunny.png" alt="John Doe"
                             class="online"/>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i
                                    class="fa fa-cog"></i> Setting</a>
                        </li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li>
                            <a href="login.php?etat=disconnect" class="padding-10 padding-top-5 padding-bottom-5"
                               data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i>
                                <strong><u>L</u>ogout</strong></a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- logout button -->
            <div id="logout" class="btn-header transparent pull-right">
                <span> <a href="<?php echo APP_URL; ?>/login.php?etat=disconnect" title="Sign Out"
                          data-action="userLogout"
                          data-logout-msg="Vous serez redirigé vers l'espace de connexion."><i
                            class="fa fa-sign-out"></i></a> </span>
            </div>
            <!-- end logout button -->

            <!-- search mobile button (this is hidden till mobile view port) -->
            <div id="search-mobile" class="btn-header transparent pull-right">
                <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
            </div>
            <!-- end search mobile button -->

            <!-- input: search field -->
            <form action="<?php echo APP_URL; ?>/search.php" class="header-search pull-right">
                <input type="text" name="param" placeholder="Rechercher..." id="search-fld">
                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i
                        class="fa fa-times"></i></a>
            </form>
            <!-- end input: search field -->

        </div>
        <!-- end pulled right: nav area -->

    </header>
    <!-- END HEADER -->

    <?php
}
?>
