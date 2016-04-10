<?php require_once("inc/init.php");
$func = new Functions(); ?>

<!-- Titre du modal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">Création d'un utilisateur</h4>
</div>

<!-- Début du formulaire -->
<form action="./php/iAjout_utilisateur.php" id="ajoutUtilisateur" class="smart-form" novalidate="novalidate"
      method="post" name="ajoutSociete">

    <div class="modal-body col-12">

        <fieldset>

            <div class="row">

                <!-- Nom de l'association -->
                <label class="label col col-2">Association</label>
                <section class="col col-3">
                    <div class="icon-addon">
                        <select class="form-control" name="selection_association" id="selection_association" required>
                            <option value="" disabled selected>Choisir une association</option>
                            <?php
                            $select = $pdo->sql("select societes_id, societes_nom from societes group by societes_nom");
                            while ($row = $select->fetch()) {
                                echo "<option " . $selected . " value=" . $row['societes_id'] . ">" . $row['societes_nom'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="email" class="fa fa-building" rel="tooltip" title=""
                               data-original-title="email"></label>
                    </div>
                </section>
                <!-- Fin de l'association -->

            </div>

            <!-- Societe local -->
            <div class="row">
                <label class="label col col-2">Local</label>
                <section class="col col-3">
                    <div class="icon-addon" style="width: 122%;">
                        <select class="form-control" name="id_local" id="select_local" required>
                            <option value="" selected="" disabled="">Choisir un local d'entreprise</option>
                            <?php

                            $select = $pdo->sql("select societes_locaux_id, societes_locaux_nom from societes_locaux where societes_id = ? group by societes_locaux_nom", array($value));
                            while ($row = $select->fetch()) {
                                echo "<option " . $selected . " value=" . $row['societes_locaux_id'] . ">" . $row['societes_locaux_nom'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="email" class="glyphicon glyphicon-search" rel="tooltip" title=""
                               data-original-title="email"></label>
                    </div>
                </section>
            </div>

            <!-- Service utilisateur -->
            <div class="row">
                <label class="label col col-2">Service utilisateur</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-cogs"></i>
                        <input type="text" name="utilisateur_service" placeholder="Service de l'utilisateur"
                               required">
                    </label>
                </section>


                <!-- Fonction -->

                <label class="label col col-2">Fonction</label>
                <section class="col col-4">
                    <label class="input fe">
                        <input type="text" name="utilisateur_fonction" placeholder="Fonction" required">
                    </label>
                </section>
            </div>
        </fieldset>

        <fieldset>
            <!-- Nom utilisateur -->
            <div class="row">
                <label class="label col col-2">Nom utilisateur</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="utilisateur_nom" placeholder="Nom de l'utilisateur" required">
                    </label>
                </section>

                <!-- Prénom de l'utilisateur -->
                <label class="label col col-2">Prénom utilisateur</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="utilisateur_prenom" placeholder="Prénom de l'utilisateur"
                               required">
                    </label>
                </section>

                <!-- Téléphone fixe utilisateur -->
                <label class="label col col-2">Téléphone fixe</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                        <input type="text" name="utilisateur_telephoneFixe" placeholder="Téléphone fixe"
                               required">
                    </label>
                </section>

                <!-- Téléphone mobile utilisateur -->
                <label class="label col col-2">Téléphone mobile</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-phone"></i>
                        <input type="text" name="utilisateur_telephoneMobile" placeholder="Téléphone mobile"
                               required">
                    </label>
                </section>

                <!-- Ville local -->
                <label class="label col col-2">Email</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-envelope-o"></i>
                        <input type="text" name="utilisateur_email" placeholder="Email" required">
                    </label>
                </section>
            </div>
        </fieldset>

        <fieldset>

            <!-- Date embauche -->
            <div class="row">
                <label class="label col col-2">Date d'embauche</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                        <input type="text" class="form-control datepicker" name="utilisateur_embauche"
                               id="utilisateur_embauche"
                               placeholder="Date d'embauche"">
                    </label>
                </section>


                <!-- Date départ -->
                <label class="label col col-2">Date départ</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                        <input type="text" class="form-control datepicker" name="utilisateur_depart"
                               id="utilisateur_depart"
                               placeholder="Date de départ">
                    </label>
                </section>
            </div>

        </fieldset>
        <!-- NOUVEAU FIELDSET -->
        <fieldset>
            <!-- Statut local -->
            <div class="row">
                <!-- Pays local -->
                <label class="label col col-2">État</label>
                <section class="col col-4">
                    <label class="input fe">
                        <input type="text" name="utilisateur_statut" placeholder="Statut" required">
                    </label>
                </section>
            </div>
            <div class="row">
                <label class="label col col-2">Commentaire</label>
                <section class="col col-10">
                    <label class="textarea">
                                <textarea rows="5" name="utilisateur_commentaire" placeholder="Commentaire"
                                          required></textarea>
                    </label>
                </section>
            </div>
        </fieldset>

        <footer>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </footer>

    </div>
</form>
<!-- Fin formulaire -->


<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">

    pageSetUp();

    // PAGE RELATED SCRIPTS

    // pagefunction

    var pagefunction = function () {

        var $checkoutForm = $('#ajoutUtilisateur').validate({
            // Rules for form validation
            rules: {
                nom_entreprise: {
                    required: true
                },
                id_local: {
                    required: true
                },
                utilisateur_service: {
                    required: true
                },
                utilisateur_nom: {
                    required: true
                },
                utilisateur_prenom: {
                    required: true
                },
                utilisateur_telephoneFixe: {
                    required: true,
                    digits: true
                },
                utilisateur_telephoneMobile: {
                    required: true,
                    digits: true
                },
                utilisateur_email: {
                    required: true,
                    email: true
                },
                utilisateur_fonction: {
                    required: true
                },
                utilisateur_statut: {
                    required: true
                },
                utilisateur_commentaire: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                nom_entreprise: {
                    required: "Veuillez sélectionner une entreprise."
                },
                id_local: {
                    required: "Veuillez sélectionner un local."
                },
                utilisateur_service: {
                    required: "Veuillez renseigner un service."
                },
                utilisateur_nom: {
                    required: "Veuillez renseigner un nom."
                },
                utilisateur_prenom: {
                    required: "Veuillez renseigner un prénom."
                },
                utilisateur_telephoneFixe: {
                    required: "Veuillez renseigner un téléphone fixe."
                },
                utilisateur_telephoneMobile: {
                    required: "Veuillez renseigner un téléphone mobile."
                },
                utilisateur_email: {
                    required: "Veuillez renseigner un email.",
                    email: "Veuillez renseigner un email correct"
                },
                utilisateur_fonction: {
                    required: "Veuillez renseigner une fonction."
                },
                utilisateur_statut: {
                    required: "Veuillez renseigner un statut."
                },
                utilisateur_commentaire: {
                    required: "Veuillez renseigner un commentaire."
                }

            },

            submitHandler: function (ev) {
                $(ev).ajaxSubmit({
                    type: $('#ajoutUtilisateur').attr('method'),
                    url: $('#ajoutUtilisateur').attr('action'),
                    data: $('#ajoutUtilisateur').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        alert('On rentre dans le success');
                        if (data.retour == '1') {
                            smallBox('Ajout impossible', 'Un utilisateur utilise déjà cet email.', 'warning');
                        }
                        else {
                            smallBox('Ajout effectué', 'Utilisateur correctement ajouté.', 'success');
                            setTimeout(function () {
                                $('#datatable_tabletools').DataTable().ajax.reload(null, false);
                            }, 500);
                        }
                        console.log(data.retour);
                    }
                });
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },

            invalidHandler: function () {
                smallBox('Ajout impossible', "Veuillez vérifier les champs.", 'error', '5000')
            }
        });


        // START AND FINISH DATE
        $('#startdate').datepicker({
            dateFormat: 'dd.mm.yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function (selectedDate) {
                $('#finishdate').datepicker('option', 'minDate', selectedDate);
            }
        });

        $('#finishdate').datepicker({
            dateFormat: 'dd.mm.yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function (selectedDate) {
                $('#startdate').datepicker('option', 'maxDate', selectedDate);
            }
        });

    };

    $("#adresse_identique input").click(function (event) {
        console.log('On est dedans : ');

        if ($('.adresse_identique').is(':disabled')) {
            console.log('lel');
            $('.adresse_identique').prop('disabled', false);
        }
        else {
            console.log('fuck');
            $('.adresse_identique').prop('disabled', true)
        }

        if ($('.fe').hasClass("state-disabled")) {
            $('.fe').removeClass("state-disabled");
        }
        else {
            $('.fe').addClass("input state-disabled");
//            $('#state-disabled').addClass("input");
        }
    });

    $('#checkbox_adresse').change(function () {
        if ($('#checkbox_adresse').prop('checked')) {
            console.log('hey');
            $.ajax({
                type: $('#ajoutUtilisateur').attr('method'),
                url: './php/iAjout_local.php',
                data: $('#ajoutUtilisateur').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.checkboxverif == '1') {
                        $("#adresse_local").val(data.adresse);
                        $("#ville_local").val(data.ville);
                        $("#code_postal_local").val(data.code_postal);
                        $("#pays_local").val(data.pays);
                    }
                }
            });
        } else {
            console.log("bad");
        }
    });

    $('#select_entreprise').change(function () {
        $.ajax({
            type: $('#ajoutUtilisateur').attr('method'),
            url: './php/iSelect_entreprise.php',
            data: {'select_entreprise': $('#select_entreprise').val()},
            dataType: 'json',
            success: function (data) {

                $('#select_local').html(data.html);

                console.log('gg');
                console.log(data);
            }
        });
    });

    // GESTION DES TABS

    $('#tabs').tabs();
    $('#tabs2').tabs();

    // Dynamic tabs
    var tabTitle = $("#tab_title"), tabContent = $("#tab_content"), tabTemplate = "<li style='position:relative;'> " +
            "<span class='air air-top-left delete-tab' style='top:7px; left:7px;'><button class='btn btn-xs font-xs btn-default hover-transparent'>" +
            "<i class='fa fa-times'></i></button></span></span><a href='#{href}'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #{label}</a></li>",
        tabCounter = 2;

    var tabs = $("#tabs2").tabs();

    loadScript("js/plugin/jquery-form/jquery-form.min.js", pagefunction);

</script>