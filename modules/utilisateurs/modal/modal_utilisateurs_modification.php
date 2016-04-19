<?php

require_once('../../../lib/config.php');

// on recupere l'id de l'utilisateur à modifier
$utilisateurs_id = $_POST['utilisateurs_id'];

// requete pour obtenir toutes les données correspondantes à cet utilisateur
$utilisateurs_data = $pdo->sqlRow("SELECT * FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id));

?>

<!-- Début du formulaire -->
<form action="modules/utilisateurs/ajax/iUtilisateur_modification.php" id="modifierUtilisateur" class="smart-form"
      novalidate="novalidate" method="post" name="modifierUtilisateur">

    <div class="modal-body col-12">

        <input class="hidden" type="text" name="utilisateurs_id" value="<?php echo $utilisateurs_id ?>"/>
        <!-- Afin d'empêcher l'autocompletion des navigateurs -->
        <input style="display:none" type="text" name="fakeusernameremembered"/>
        <input style="display:none" type="password" name="fakepasswordremembered"/>

        <!-- ASSOCIATION -->
        <fieldset>

            <legend>Informations association</legend>

            <div class="row">

                <!-- Nom de l'association -->
                <label class="label col col-2">Nom association</label>
                <section class="col col-4">
                    <label class="select">
                        <select name="associations_id" id="associations_id" required data-show-icon="true">
                            <option value="" disabled selected> &nbsp;&nbsp;Choisir une association</option>
                            <?php
                            $select = $pdo->sql("select associations_id, associations_nom from associations group by associations_nom");

                            while ($row = $select->fetch()) {
                                // on recupere la valeur pour l'utilisateur
                                $associations_id = $pdo->sqlValue("SELECT associations_id FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id));
                                // on selectionne si =
                                $selected = ($row['associations_id'] == $associations_id) ? 'selected' : '';

                                echo "<option " . $selected . " value=" . $row['associations_id'] . ">" . $row['associations_nom'] . "</option>";
                            }
                            ?>
                        </select> <i></i> </label>
                </section>
                <!-- Fin nom de l'association -->

            </div>

        </fieldset>
        <!-- FIN ASSOCIATION -->

        <!-- UTILISATEUR -->
        <fieldset>

            <legend>Informations utilisateur</legend>

            <div class="row">

                <!-- Type de l'utilisateur -->
                <label class="label col col-2">Type d'utilisateur</label>
                <section class="col col-4">
                    <label class="select">
                        <select name="utilisateurs_type" id="utilisateurs_type" required>
                            <option value="" disabled selected> &nbsp;&nbsp;Choisir un type</option>
                            <?php
                            $select = $pdo->sql("select utilisateurs_type_id , utilisateurs_type_nom from utilisateurs_type group by utilisateurs_type_nom");

                            while ($row = $select->fetch()) {
                                // on recupere la valeur pour l'utilisateur
                                $associations_id = $pdo->sqlValue("SELECT utilisateurs_type FROM utilisateurs WHERE utilisateurs_id = ?", array($utilisateurs_id));
                                // on selectionne si =
                                $selected = ($row['utilisateurs_type_id'] == $associations_id) ? 'selected' : '';

                                echo "<option " . $selected . " value=" . $row['utilisateurs_type_id'] . ">" . $row['utilisateurs_type_nom'] . "</option>";
                            }
                            ?>
                        </select> <i></i> </label>
                </section>

            </div>
            <!-- Fin type de l'utilisateur -->

            <div class="row">

                <!-- Nom de l'utilisateur -->
                <label class="label col col-2">Nom</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="utilisateurs_nom" placeholder="Nom de l'utilisateur" required
                               value="<?php echo $utilisateurs_data['utilisateurs_nom'] ?>">
                    </label>
                </section>
                <!-- Fin nom de l'utilisateur -->

                <!-- Prénom de l'utilisateur -->
                <label class="label col col-2">Prénom</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="utilisateurs_prenom" placeholder="Prénom de l'utilisateur" required
                               value="<?php echo $utilisateurs_data['utilisateurs_prenom'] ?>">
                    </label>
                </section>
                <!-- Fin prénom de l'utilisateur -->

            </div>

            <div class="row">

                <!-- E-mail de l'utilisateur -->
                <label class="label col col-2">E-mail</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-envelope"></i>
                        <input type="text" name="utilisateurs_email" placeholder="exemple@live.fr" required
                               value="<?php echo $utilisateurs_data['utilisateurs_email'] ?>">
                    </label>
                </section>
                <!-- Fin e-mail de l'utilisateur -->

                <!-- Mot de passe de l'utilisateur -->
                <label class="label col col-2">Mot de passe</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-lock"></i>
                        <input type="password" name="utilisateurs_motDePasse" placeholder="********" required
                               value="">
                    </label>
                </section>
                <!-- Fin mot de passe de l'utilisateur -->

            </div>

            <div class="row">
                <label class="label col col-2">Avatar</label>
                <section class="col col-10">
                    <label for="file" class="input input-file">
                        <div class="button"><input type="file" name="utilisateurs_avatar" onchange="this.parentNode.nextSibling.value = this.value">Chercher</div><input type="text" readonly=""></label>
                    <div class="note note-error">L'image ne doit pas être supérieure à 3Mo.</div>
                </section>
            </div>
        </fieldset>
        <!-- FIN UTILISATEUR -->

        <footer>
            <button type="submit" class="btn btn-success">Modifier !</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </footer>

    </div>
</form>
<!-- Fin formulaire -->


<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">

    pageSetUp();

    var pagefunction = function () {
        var $checkoutForm = $('#modifierUtilisateur').validate({
            // Rules for form validation
            rules: {
                associations_id: {
                    required: true
                },
                utilisateurs_type: {
                    required: true
                },
                utilisateurs_nom: {
                    required: true
                },
                utilisateurs_prenom: {
                    required: true
                },
                utilisateurs_email: {
                    required: true,
                    email: true
                },
                utilisateurs_motDePasse: {
                    required: false
                },
                utilisateurs_avatar: {
                    required: false
                }
            },

            // Messages for form validation
            messages: {
                associations_id: {
                    required: "Veuillez renseigner une association."
                },
                utilisateurs_type: {
                    required: "Veuillez sélectionner un type pour l'utilisateur."
                },
                utilisateurs_nom: {
                    required: "Veuillez renseigner un nom pour l'utilisateur."
                },
                utilisateurs_prenom: {
                    required: "Veuillez renseigner un prénom pour l'utilisateur."
                },
                utilisateurs_email: {
                    required: "Veuillez renseigner un e-mail pour l'utilisateur.",
                    email: "Veuillez renseigner un e-mail correct."
                },
                utilisateurs_motDePasse: {
                    required: ""
                },
                utilisateurs_avatar: {
                    required: ""
                }
            },

            submitHandler: function (ev) {
                $(ev).ajaxSubmit({
                    type: $('#modifierUtilisateur').attr('method'),
                    url: $('#modifierUtilisateur').attr('action'),
                    data: $('#modifierUtilisateur').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.return == 'email') {
                            smallBox('Ajout impossible', 'Un utilisateur possède déjà cet e-mail.', 'warning');
                        } else if (data.return == 'avatar') {
                            smallBox('Ajout impossible', 'Une erreur est survenue avec l\'avatar.', 'warning');
                        } else {
                            smallBox('Ajout réussi !', 'L\'utilisateur à correctement été ajouté.', 'success');
                            setTimeout(function () {
                                $('#listing_utilisateurs').DataTable().ajax.reload(null, false); // refresh la datable utilisateur
                            }, 500);
                            $('#utilisateurs_modification').modal('toggle'); // ferme le modal en cas d'ajout
                        }
                        console.log(data.retour);
                    }
                });
            },

            // Ne pas changer le code suivant
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },

            invalidHandler: function () {
                smallBox('Erreur', "Veuillez remplir les champs correctement.", 'error', '3000')
            }
        });
    };

    loadScript("assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);

</script>