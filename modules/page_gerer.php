<?php require_once("inc/init.php"); ?>

<?php if ($_SESSION['utilisateurs_admin'] == 1) {
    echo "<button type='button' class='well' onclick='ouverture_stage_ajout();'" . "><i class='fa fa-plus-square'></i>&nbsp;&nbsp;Créer
    un stage
    </button >";
}
?>


<!-- Container datatable -->
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
             data-widget-fullscreenbutton="false">

            <header>
                <span class="widget-icon">
                    <i class="fa fa-building"></i>
                </span>
                <h2>Stages auxquels vous-êtes inscrits</h2>
            </header>

            <!-- debut widget-->
            <div>
                <div class="jarviswidget-editbox">
                </div>

                <!-- contenu widget -->
                <div class="widget-body no-padding">
                    <form id="tableau">
                        <table id="listing_stages" class="table table-striped table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Intitulé</th>
                                <th>Association</th>
                                <th>Salles</th>
                                <th>Prix</th>
                                <th>Places restantes</th>
                                <th>Date formations</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </form>
                </div>
                <!-- fin contenu widget -->
            </div>
            <!-- fin widget -->
        </div>
    </article>
</div>
<!-- fin container-->

<!-- modal ajout association-->
<div class="modal fade" id="stage_ajout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- fin modal ajout -->

<!-- modal ajout association-->
<div class="modal fade" id="stage_modification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- fin modal ajout -->

<script type="text/javascript">

    $(document).ready(function () {

        pageSetUp();

        var pagefunction = function () {

            localStorage.clear();

            var responsiveHelper_listing_stages = undefined;

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $('#listing_stages').dataTable({
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                "oTableTools": {
                    "aButtons": [
                        "xls",
                        {
                            "sExtends": "print",
                            "sMessage": "Généré par Forma <i>(Appuyez sur Echap pour fermer)</i>"
                        }
                    ],
                    "sSwfPath": "assets/js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                },
                "autoWidth": true,
                "preDrawCallback": function () {
                    if (!responsiveHelper_listing_stages) {
                        responsiveHelper_listing_stages = new ResponsiveDatatablesHelper($('#listing_stages'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_listing_stages.createExpandIcon(nRow);
                },
                "ajax": "modules/gerer/ajax/iGerer_listing.php",
                "drawCallback": function (oSettings) {
                    responsiveHelper_listing_stages.respond();
                },
                "language": {
                    "url": "./data/traduction_datatables_fr.json"
                }
            });

        };

        loadScript("assets/js/plugin/datatables/jquery.dataTables.min.js", function () {
            loadScript("assets/js/plugin/datatables/dataTables.colVis.min.js", function () {
                loadScript("assets/js/plugin/datatables/dataTables.tableTools.min.js", function () {
                    loadScript("assets/js/plugin/datatables/dataTables.bootstrap.min.js", function () {
                        loadScript("assets/js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
                    });
                });
            });
        });

    });

    function desinscrireUtilisateurs(stages_formations_id) {
        $.ajax({
            url: 'modules/gerer/ajax/iGerer_desinscrire.php',
            type: 'POST',
            data: {"stages_formations_id": stages_formations_id},
            dataType: 'html',
            success: function (contenu) {
                smallBox('Désinscription', "Vous êtes correctement désinscris.", 'success');
                setTimeout(function () {
                    $('#listing_stages').DataTable().ajax.reload(null, false); // refresh la datable association
                }, 500);
            },
            error: function () {
                smallBox('Erreur', 'Une erreur est survenu dans la fonction suppressionLigne(paramId).', 'warning');
            }
        });
    }

    function ouverture_stage_ajout() {
        $.ajax({
            url: 'modules/stages/modal/modal_stages_ajout.php',
            type: 'POST',
            data: '',
            dataType: 'html',
            success: function (contenu) {
                $('#stage_ajout .modal-content').html(contenu);
                $('#stage_ajout').modal('show');
            },
            error: function () {
                alert('erreur lors du retour JSON !');
            }
        });
    }

    function ouverture_stages_modification(stages_id) {
        $.ajax({
            url: 'modules/stages/modal/modal_stages_modification.php',
            type: 'POST',
            data: {"stages_id": stages_id},
            dataType: 'html',
            success: function (contenu) {
                $('#stage_modification .modal-content').html(contenu);
                $('#stage_modification').modal('show');
            },
            error: function () {
                alert('erreur lors du retour JSON !');
            }
        });
    }

    function suppressionLigne(stagesId) {
        $.SmartMessageBox({
            title: "Attention !",
            content: "Vous êtes sur le point de supprimer ce stage, confirmer ?",
            buttons: '[Non][Oui]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Oui") {
                $.ajax({
                    url: 'modules/stages/ajax/iStages_suppression.php',
                    type: 'POST',
                    data: {'id': stagesId},
                    dataType: 'html',
                    success: function (contenu) {
                        smallBox('Suppression', "Le stage à correctement été supprimé.", 'success');
                        setTimeout(function () {
                            $('#listing_stages').DataTable().ajax.reload(null, false); // refresh la datable association
                        }, 500);
                    },
                    error: function () {
                        smallBox('Erreur', 'Une erreur est survenu dans la fonction suppressionLigne(paramId).', 'warning');
                    }
                });
            }
            if (ButtonPressed === "Non") {
                smallBox('Suppression', "Le stage n'a pas été supprimé.", 'warning');
            }
        });
    }

    function inscriptionUtilisateurs(stageId) {
        $.ajax({
            url: 'modules/stages/ajax/iStages_inscription.php',
            type: 'POST',
            data: {'stage_id': stageId},
            dataType: 'json',
            success: function (data) {
                if (data.return == "ok") {
                    smallBox('Inscription', 'Utilisateurs correctement inscrit à la formation.', 'success');
                } else if (data.return == "limite") {
                    smallBox('Avertissement', 'L\'utilisateur à depassé son nombre limite d\'inscription.', 'warning');
                } else {
                    smallBox('Erreur', 'Une erreur à surgit durant l\'inscription de l\'utilisateur.', 'error')
                }
            },
            error: function () {
                alert('Erreur lors du retour JSON !');
            }
        });
    }

</script>