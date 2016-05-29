<?php require_once('../../../lib/config.php');

// on recupere l'id de l'utilisateur à modifier
$stage_id = $_POST['stages_id'];

// requete pour obtenir toutes les données correspondantes à cet utilisateur
$stage_data = $pdo->sqlRow("SELECT * FROM stages_formations WHERE stages_formations_id = ?", array($stage_id));

?>

<!-- Début du formulaire -->
<form action="modules/stages/ajax/iStages_modification.php" id="modificationStage" class="smart-form"
      novalidate="novalidate" method="post" name="modificationStage">

    <div class="modal-body col-12">

        <input class="hidden" type="text" name="stages_formations_id" value="<?php echo $stage_id ?>"/>
        <!-- Afin d'empêcher l'autocompletion des navigateurs -->
        <input style="display:none" type="text" name="fakeusernameremembered"/>
        <input style="display:none" type="password" name="fakepasswordremembered"/>

        <!-- STAGES -->
        <fieldset>

            <legend>Catégorie & emplacement</legend>

            <div class="row">

                <!-- Nom de la formation -->
                <label class="label col col-2">Formation</label>
                <section class="col col-4">
                    <label class="select">
                        <select name="formations_id" id="formations_id" required data-show-icon="true">
                            <option value="" disabled selected> &nbsp;&nbsp;Choisir une formation</option>
                            <?php
                            $select = $pdo->sql("select formations_id, formations_intitule from formations group by formations_intitule");

                            while ($row = $select->fetch()) {
                                // on recupere la valeur pour le stage
                                $stage_formation_id = $pdo->sqlValue("SELECT formations_id FROM stages_formations WHERE stages_formations_id = ?", array($stage_id));

                                $selected = ($row['formations_id'] == $stage_formation_id) ? 'selected' : '';

                                echo "<option " . $selected . " value=" . $row['formations_id'] . ">" . $row['formations_intitule'] . "</option>";
                            }
                            ?>
                        </select> <i></i> </label>
                </section>
                <!-- Fin nom de la formation -->

            </div>

            <div class="row">

                <!-- Nom de la salle -->
                <label class="label col col-2">Salle</label>
                <section class="col col-4">
                    <label class="select">
                        <select name="salles_id" id="salles_id" required data-show-icon="true">
                            <option value="" disabled selected> &nbsp;&nbsp;Choisir une salle</option>
                            <?php
                            $select = $pdo->sql("select salles_id, salles_nom from salles group by salles_nom");

                            while ($row = $select->fetch()) {
                                // on recupere la valeur pour le stage
                                $stage_salle_id = $pdo->sqlValue("SELECT salles_id FROM stages_formations WHERE stages_formations_id = ?", array($stage_id));

                                $selected = ($row['salles_id'] == $stage_salle_id) ? 'selected' : '';

                                echo "<option " . $selected . " value=" . $row['salles_id'] . ">" . $row['salles_nom'] . "</option>";
                            }
                            ?>
                        </select> <i></i> </label>
                </section>
                <!-- Fin nom de la salle  -->

            </div>

        </fieldset>

        <fieldset>

            <legend>Détails</legend>

            <div class="row">

                <!-- Prix du stage -->
                <label class="label col col-2">Prix</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-eur"></i>
                        <input type="text" name="stages_prix" placeholder="Prix du stage" required
                               value="<?php echo $stage_data['stages_formations_prix']; ?>">
                    </label>
                </section>
                <!-- Fin prix du stage -->

                <!-- Place pour le stage -->
                <label class="label col col-2">Places</label>
                <section class="col col-4">
                    <label class="input fe"> <i class="icon-prepend fa fa-ticket"></i>
                        <input type="text" name="stages_places" placeholder="Places disponibles" required
                               value="<?php echo $stage_data['stages_formations_placeRestantes']; ?>">
                    </label>
                </section>
                <!-- Fin place pour le stage -->

            </div>

            <div class="row">

                <!-- Date pour le stage -->

                <label class="label col col-2">Date</label>
                <section class="col col-4">
                    <label class="input"> <i class="icon-prepend fa fa-calendar-o"></i>
                        <input type="text" class="form-control datepicker" name="stages_date"
                               placeholder="Date du stage" required readonly="readonly"
                               value="<?php echo $func->dateFR($stage_data['stages_formations_date']); ?>">
                    </label>
                </section>
                <!-- Fin date pour le stage -->

            </div>

        </fieldset>
        <!-- FIN STAGE -->

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
        var $checkoutForm = $('#modificationStage').validate({
            // Rules for form validation
            rules: {
                formations_id: {
                    required: true
                },
                salles_id: {
                    required: true
                },
                stages_prix: {
                    required: true,
                    number: true
                },
                stages_places: {
                    required: true,
                    digits: true
                },
                stages_date: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                formations_id: {
                    required: "Veuillez sélectionner une formation"
                },
                salles_id: {
                    required: "Veuillez sélectionner une salle"
                },
                stages_prix: {
                    required: "Veuillez renseigner un prix",
                    number: "Veuillez indiquer un prix correct"
                },
                stages_places: {
                    required: "Veuillez renseigner le nombre de place",
                    digits: "Veuillez indiquer un nombre de place correct"
                },
                stages_date: {
                    required: "Veuillez renseigner la date du stage"
                }
            },

            submitHandler: function (ev) {
                $(ev).ajaxSubmit({
                    type: $('#modificationStage').attr('method'),
                    url: $('#modificationStage').attr('action'),
                    data: $('#modificationStage').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.return == 'ok') {
                            smallBox('Modification réussie !', 'Le stage a correctement été modifié.', 'success');
                            setTimeout(function () {
                                $('#listing_stages').DataTable().ajax.reload(null, false); // refresh la datable utilisateur
                            }, 500);
                            $('#stage_modification').modal('toggle'); // ferme le modal en cas d'ajout
                        } else {
                            smallBox('Erreur', 'Une erreur est survenue lors de la modification.', 'error');
                        }
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