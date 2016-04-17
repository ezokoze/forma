<?php

if ($_GET['etat'] == 'disconnect') {
    session_start();
    session_unset();
    session_destroy();
}

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
$page_title = "Custom Title" */

$page_title = "Connexion";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_body_prop = array("id" => "extr-page", "class" => "animated fadeInDown");
include("inc/header.php");

?>
    <!-- ==========================CONTENT STARTS HERE ========================== -->
    <!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
    <header id="header">

    </header>

    <div id="main" role="main">


        <!-- MAIN CONTENT -->
        <div id="content" class="container">

            <div class="container">
                <div class="col-xs-9 col-md-7 col-lg-6 col-centered">
                    <div class="well no-padding">
                        <form action="modules/connexion/connexion.php" id="login-form" class="smart-form client-form"
                              method="post">
                            <header>
                                Connexion à Forma
                            </header>

                            <fieldset>

                                <section>
                                    <label class="label">Identifiant</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="email" name="email">
                                        <b class="tooltip tooltip-top-right"><i
                                                class="fa fa-user txt-color-teal"></i> Veuillez entrer votre
                                            identifiant</b></label>
                                </section>

                                <section>
                                    <label class="label">Mot de passe</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password">
                                        <b class="tooltip tooltip-top-right"><i
                                                class="fa fa-lock txt-color-teal"></i> Entrer votre mot de passe</b>
                                    </label>
                                    <div class="note">
                                        <a href="<?php echo APP_URL; ?>/forgotpassword.php">Mot de passe oublié
                                            ?</a>
                                    </div>
                                </section>

                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember" checked="">
                                        <i></i>Rester connecté</label>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    Me connecter !
                                </button>
                            </footer>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END MAIN PANEL -->
    <!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
//include required scripts
include("inc/scripts.php");
?>

    <!-- PAGE RELATED PLUGIN(S)
    <script src="..."></script>-->

    <script type="text/javascript">
        runAllForms();

        $(function () {
            // Validation
            $("#login-form").validate({
                // Rules for form validation
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    }
                },

                // Messages for form validation
                messages: {
                    email: {
                        required: 'Please enter your email address',
                        email: 'Please enter a VALID email address'
                    },
                    password: {
                        required: 'Please enter your password'
                    }
                },

                // Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>

<?php
//include footer
include("inc/google-analytics.php");
?>