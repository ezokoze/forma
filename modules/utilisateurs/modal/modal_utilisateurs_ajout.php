<?php require_once('../../../lib/config.php'); ?>

<!-- Début du formulaire -->
<form action="modules/utilisateurs/ajax/iUtilisateur_ajout.php" id="ajoutUtilisateur" class="smart-form"
      novalidate="novalidate" method="post" name="ajoutUtilisateur">

    <div class="modal-body col-12">

        <!-- ASSOCIATION -->
        <fieldset>

            <legend>Informations association</legend>

            <div class="row">
                <!-- Nom de l'association -->
                <label class="label col col-2">Nom association</label>
                <section class="col col-3">
                    <div class="icon-addon" style="width: 122%;">
                        <select class="form-control" name="associations_id" id="associations_id" required>
                            <option value="" disabled selected>Choisir une association</option>
                            <?php
                            $select = $pdo->sql("select associations_id, associations_nom from associations group by associations_nom");

                            while ($row = $select->fetch()) {
                                echo "<option " . $selected . " value=" . $row['associations_id'] . ">" . $row['associations_nom'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="email" class="fa fa-building" rel="tooltip" title=""
                               data-original-title="association"></label>
                    </div>
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
                <section class="col col-3">
                    <div class="icon-addon" style="width: 122%;">
                        <select class="form-control" name="utilisateurs_type" id="utilisateurs_type" required>
                            <option value="" disabled selected>Choisir un type</option>
                            <option value="Salarié">Salarié</option>
                            <option value="Bénévole">Bénévole</option>

                        </select>
                        <label for="email" class="fa fa-tag" rel="tooltip" title=""
                               data-original-title="type"></label>
                    </div>
                </section>
                <!-- Fin type de l'utilisateur -->
            </div>

            <div class="row">

                <!-- Nom de l'utilisateur -->
                <label class="label col col-2">Nom</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="utilisateurs_nom" placeholder="Nom de l'utilisateur" required">
                    </label>
                </section>
                <!-- Fin nom de l'utilisateur -->

                <!-- Prénom de l'utilisateur -->
                <label class="label col col-2">Prénom</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="utilisateurs_prenom" placeholder="Prénom de l'utilisateur" required">
                    </label>
                </section>
                <!-- Fin prénom de l'utilisateur -->

            </div>

            <div class="row">

                <!-- E-mail de l'utilisateur -->
                <label class="label col col-2">E-mail</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-envelope"></i>
                        <input type="text" name="utilisateurs_email" placeholder="exemple@live.fr" required">
                    </label>
                </section>
                <!-- Fin e-mail de l'utilisateur -->

                <!-- Mot de passe de l'utilisateur -->
                <label class="label col col-2">Mot de passe</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-lock"></i>
                        <input type="password" name="utilisateurs_motDePasse" placeholder="******" required">
                    </label>
                </section>
                <!-- Fin mot de passe de l'utilisateur -->

            </div>
        </fieldset>
        <!-- FIN UTILISATEUR -->

        <footer>
            <button type="submit" class="btn btn-success">Créer !</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </footer>

    </div>
</form>
<!-- Fin formulaire -->


<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">

    pageSetUp();

    var pagefunction = function () {
        var $checkoutForm = $('#ajoutUtilisateur').validate({
            // Rules for form validation
            rules: {
                associations_id: {
                    required: true
                },
                utilisateurs_type:{
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
                    required: true
                },
            },

            // Messages for form validation
            messages: {
                associations_id: {
                    required: "Veuillez renseigner une association."
                },
                utilisateurs_type:{
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
                    required: "Veuillez renseigner un mot de passe pour l'utilisateur."
                },
            },

            submitHandler: function (ev) {
                $(ev).ajaxSubmit({
                    type: $('#ajoutUtilisateur').attr('method'),
                    url: $('#ajoutUtilisateur').attr('action'),
                    data: $('#ajoutUtilisateur').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.return == 'email') {
                            smallBox('Ajout impossible', 'Un utilisateur possède déjà cet e-mail.', 'warning');
                        } else {
                            smallBox('Ajout réussi !', 'L\'utilisateur à correctement été ajouté.', 'success');
                            setTimeout(function () {
                                $('#listing_utilisateurs').DataTable().ajax.reload(null, false); // refresh la datable utilisateur
                            }, 500);
                            $('#utilisateurs_ajout').modal('toggle'); // ferme le modal en cas d'ajout
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
                smallBox('Ajout impossible', "Veuillez remplir les champs correctement.", 'error', '3000')
            }
        });
    };

    loadScript("assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);

</script>