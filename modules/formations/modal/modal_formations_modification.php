<?php require_once('../../../lib/config.php');

// on recupere l'id de l'utilisateur à modifier
$formations_id = $_POST['formations_id'];

// requete pour obtenir toutes les données correspondantes à cet utilisateur
$formations_data = $pdo->sqlRow("SELECT * FROM formations WHERE formations_id = ?", array($formations_id));

?>

<!-- Début du formulaire -->
<form action="modules/formations/ajax/iFormation_modification.php" id="modificationFormation" class="smart-form"
      novalidate="novalidate" method="post" name="modificationFormation" xmlns="http://www.w3.org/1999/html">

    <div class="modal-body col-12">

        <input class="hidden" type="text" name="formations_id" value="<?php echo $formations_id ?>"/>
        <!-- Afin d'empêcher l'autocompletion des navigateurs -->
        <input style="display:none" type="text" name="fakeusernameremembered"/>
        <input style="display:none" type="password" name="fakepasswordremembered"/>

        <!-- FORMATION -->
        <fieldset>

            <legend>Informations Générales</legend>

            <div class="row">

                <!-- Intitulé formation -->
                <label class="label col col-2">Intitulé</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-quote-left"></i>
                        <input type="text" name="formations_intitule" placeholder="Intitulé de formation" required
                               value="<?php echo $formations_data['formations_intitule']; ?>">
                    </label>
                </section>
                <!-- Fin intitulé formation -->

                <!-- Domaine formation -->
                <label class="label col col-2">Domaine formation</label>
                <section class="col col-4">
                    <label class="select">
                        <select name="formations_domaine" id="formations_domaine" required data-show-icon="true">
                            <option value="" disabled selected>Choisir un domaine</option>
                            <?php
                            $select = $pdo->sql("select domaines_id, domaines_nom from domaines group by domaines_nom");

                            while ($row = $select->fetch()) {
                                // on recupere la valeur pour la formation
                                $domaine_formation_id = $pdo->sqlValue("SELECT domaines_id FROM formations WHERE formations_id = ?", array($formations_id));
                                // on selectionne si =
                                $selected = ($row['domaines_id'] == $domaine_formation_id) ? 'selected' : '';

                                echo "<option " . $selected . " value=" . $row['domaines_id'] . ">" . $row['domaines_nom'] . "</option>";
                            }
                            ?>
                        </select> <i></i> </label>
                </section>
                <!-- Fin domaine formation -->

            </div>

            <div class="row">
                <!-- Date début formation -->
                <label class="label col col-2">Date début</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-calendar-o"></i>
                        <input type="text" class="form-control datepicker" name="formation_dateDebut"
                               placeholder="Date début formation" required
                               value="<?php echo $func->dateFR($formations_data['formations_dateDebut']); ?>">
                    </label>
                </section>
                <!-- Fin date début formation -->

                <!-- Date fin formation -->
                <label class="label col col-2">Date fin</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-calendar-o"></i>
                        <input type="text" class="form-control datepicker" name="formation_dateFin"
                               placeholder="Date fin formation" required
                               value="<?php echo $func->dateFR($formations_data['formations_dateFin']); ?>">
                    </label>
                </section>
                <!-- Fin date fin formation -->

            </div>

        </fieldset>

        <!-- FIN FORMATION -->

        <!-- INTERVENANT -->
        <fieldset>
            <legend>Intervenant</legend>

            <div class="row">

                <!-- Nom de l'intervenant -->
                <label class="label col col-2">Nom</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="intervenant_nom" placeholder="Nom de l'intervenant" required
                               value="<?php echo $formations_data['intervenants_nom']; ?>">
                    </label>
                </section>
                <!-- Fin nom de l'intervenant -->

                <!-- Prénom de l'intervenant -->
                <label class="label col col-2">Prénom</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-user"></i>
                        <input type="text" name="intervenant_prenom" placeholder="Prénom de l'intervenant" required
                               value="<?php echo $formations_data['intervenants_prenom']; ?>">
                    </label>
                </section>
                <!-- Fin prénom de l'intervenant -->

            </div>

            <div class="row">

                <!-- Poste de l'intervenant -->
                <label class="label col col-2">Poste</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-tags"></i>
                        <input type="text" name="intervenant_poste" placeholder="Poste de l'intervenant" required
                               value="<?php echo $formations_data['intervenants_poste']; ?>">
                    </label>
                </section>
                <!-- Fin poste de l'intervenant -->

                <!-- E-mail de l'interevenant -->
                <label class="label col col-2">E-mail</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-envelope"></i>
                        <input type="text" name="intervenant_email" placeholder="exemple@hotmail.fr" required
                               value="<?php echo $formations_data['intervenants_email']; ?>">
                    </label>
                </section>
                <!-- Fin e-mail de l'interevenant -->

            </div>

        </fieldset>
        <!-- FIN INTERVENANT -->

        <!-- DETAILS -->
        <fieldset>

            <legend>Détails</legend>

            <div class="row">

                <!-- Lieu formation -->
                <label class="label col col-2">Lieu</label>
                <section class="col col-4">
                    <label class="select">
                        <select name="formations_lieu" id="formations_lieu" required>
                            <option value="" disabled selected> &nbsp;&nbsp;Choisir une salle</option>
                            <?php
                            $select = $pdo->sql("select salles_id , salles_nom from salles group by salles_nom");

                            while ($row = $select->fetch()) {
                                // on recupere la valeur pour la formation
                                $salles_formation_id = $pdo->sqlValue("SELECT salles_id FROM formations WHERE formations_id = ?", array($formations_id));
                                // on selectionne si =
                                $selected = ($row['salles_id'] == $salles_formation_id) ? 'selected' : '';

                                echo "<option " . $selected . " value=" . $row['salles_id'] . ">" . $row['salles_nom'] . "</option>";
                            }
                            ?>
                        </select> <i></i> </label>
                </section>
                <!-- Fin lieu formation -->

                <!-- Difficulté formation -->
                <label class="label col col-3">Difficulté</label>
                <section class="col col-3">
                    <div class="rating">
                        <input type="radio" name="difficulte" id="difficulte-5"
                               value="5" <?php echo($formations_data['formations_niveau'] == 5 ? 'checked' : '') ?>>
                        <label for="difficulte-5"><i class="fa fa-star"></i></label>
                        <input type="radio" name="difficulte" id="difficulte-4"
                               value="4"<?php echo($formations_data['formations_niveau'] == 4 ? 'checked' : '') ?>>
                        <label for="difficulte-4"><i class="fa fa-star"></i></label>
                        <input type="radio" name="difficulte" id="difficulte-3"
                               value="3" <?php echo($formations_data['formations_niveau'] == 3 ? 'checked' : '') ?>>
                        <label for="difficulte-3"><i class="fa fa-star"></i></label>
                        <input type="radio" name="difficulte" id="difficulte-2"
                               value="2" <?php echo($formations_data['formations_niveau'] == 2 ? 'checked' : '') ?>>
                        <label for="difficulte-2"><i class="fa fa-star"></i></label>
                        <input type="radio" name="difficulte" id="difficulte-1"
                               value="1" <?php echo($formations_data['formations_niveau'] == 1 ? 'checked' : '') ?>>
                        <label for="difficulte-1"><i class="fa fa-star"></i></label>
                    </div>
                </section>
                <!-- Fin difficulté formation -->

            </div>

            <div class="row">

                <!-- Prix formation -->
                <label class="label col col-2">Prix</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-eur"></i>
                        <input type="text" name="formations_prix" placeholder="Prix de la formation" required
                               value="<?php echo $formations_data['formations_prix']; ?>">
                    </label>
                </section>
                <!-- Fin prix formation -->

                <!-- Date limite formation -->
                <label class="label col col-2">Date limite</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-calendar-times-o"></i>
                        <input type="text" class="form-control datepicker" name="formations_dateLimite"
                               placeholder="Date limite d'inscription" required
                               value="<?php echo $func->dateFR($formations_data['formations_dateLimite']); ?>">
                    </label>
                </section>
                <!-- Fin date limite formation -->

            </div>

            <div class="row">

                <!-- Contenu formation -->
                <label class="label col col-2">Contenu</label>
                <section class="col col-10">
                    <label class="textarea">
                                <textarea rows="5" name="formations_contenu" placeholder="Commentaire"
                                          required><?php echo $formations_data['formations_contenu']; ?></textarea>
                    </label>
                </section>
                <!-- Fin contenu formation-->

            </div>

        </fieldset>
        <!-- FIN DETAILS -->


        <footer>
            <button type="submit" class="btn btn-success">Modifier !</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </footer>

    </div>
</form>
<!-- Fin formulaire -->


<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript" src="<?php echo ASSETS_URL; ?>/assets/js/plugin/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {


        pageSetUp();

        var pagefunction = function () {

            tinymce.init({
                selector: 'textarea',
                statusbar: false,
                height: 200,
                menu: {},
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code',
                    'textcolor'
                ],
                toolbar: 'insertfile undo redo | styleselect | forecolor bold italic | alignleft aligncenter alignright | bullist numlist | table',
                content_css: [
                    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',

                ]
            });


            var $checkoutForm = $('#modificationFormation').validate({
                // Rules for form validation
                rules: {
                    formations_intitule: {
                        required: true
                    },
                    formations_domaine: {
                        required: true
                    },
                    difficulte: {
                        required: true
                    },
                    formations_prix: {
                        required: true,
                        number: true
                    },
                    formations_contenu: {
                        required: true
                    },
                    intervenant_nom: {
                        required: true
                    },
                    intervenant_prenom: {
                        required: true
                    },
                    intervenant_poste: {
                        required: true
                    },
                    intervenant_email: {
                        required: true,
                        email: true
                    },
                    formations_lieu: {
                        required: true
                    },
                    formation_dateDebut: {
                        required: true
                    },
                    formation_dateFin: {
                        required: true
                    },
                    formations_dateLimite: {
                        required: true
                    }
                },

                // Messages for form validation
                messages: {
                    formations_intitule: {
                        required: "Veuillez saisir un intitulé pour la formation."
                    },
                    formations_domaine: {
                        required: "Veuillez choisir un domaine pour la formation."
                    },
                    difficulte: {
                        required: "Veuillez indiquer la difficulté de la formation."
                    },
                    formations_prix: {
                        required: "Veuillez indiquer un prix pour la formation.",
                        number: "Veuillez indiquer un prix correct pour la formation."
                    },
                    formations_contenu: {
                        required: "Veuillez indiquer le contenu de la formation."
                    },
                    intervenant_nom: {
                        required: "Veuillez indiquer le nom de l'intervenant pour cette formation."
                    },
                    intervenant_prenom: {
                        required: "Veuillez indiquer le prénom de l'intervenant pour cette formation."
                    },
                    intervenant_poste: {
                        required: "Veuillez indiquer le poste de l'intervenant."
                    },
                    intervenant_email: {
                        required: "Veuillez indiquer un email pour l'intervenant.",
                        email: "Veuillez indiquer un email correct."
                    },
                    formations_lieu: {
                        required: "Veuillez indiquer un lieu pour la formation."
                    },
                    formation_dateDebut: {
                        required: "Veuillez indiquer une date de début pour la formation"
                    },
                    formation_dateFin: {
                        required: "Veuillez indiquer une date de fin pour la formation."
                    },
                    formations_dateLimite: {
                        required: "Veuillez indiquer une date limite pour la formation."
                    }
                },

                submitHandler: function (ev) {
                    $(ev).ajaxSubmit({
                        type: $('#modificationFormation').attr('method'),
                        url: $('#modificationFormation').attr('action'),
                        data: $('#modificationFormation').serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (data.return == 'intitule') {
                                smallBox('Modification impossible', 'Une formation portant le même nom dans ce domaine existe déjà.', 'warning');
                            } else {
                                smallBox('Modification réussie !', 'La formation à correctement été modifiée.', 'success');
                                setTimeout(function () {
                                    $('#listing_formations').DataTable().ajax.reload(null, false); // refresh la datable utilisateur
                                    $('#formations_modification').modal('toggle'); // ferme le modal en cas d'ajout
                                }, 500);

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

        $('.form-control datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });
        loadScript("assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);
    });


</script>