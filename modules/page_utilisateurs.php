<?php require_once("inc/init.php"); ?>

<button type="button" class="well" onclick="ouverture_utilisateurs_ajout();"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Créer
    un utilisateur
</button>

<!-- Container datatable -->
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
             data-widget-fullscreenbutton="false">

            <header>
                <span class="widget-icon">
                    <i class="fa fa-building"></i>
                </span>
                <h2>Utilisateurs</h2>
            </header>

            <!-- debut widget-->
            <div>
                <div class="jarviswidget-editbox">
                </div>

                <!-- contenu widget -->
                <div class="widget-body no-padding">
                    <form id="tableau">
                        <table id="listing_utilisateurs" class="table table-striped table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Association</th>
                                <th>Type utilisateur</th>
                                <th>Nom</th>
                                <th>E-mail</th>
                                <th>Quota</th>
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

<!-- modal-->
<div class="modal fade" id="utilisateurs_ajout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div> <!-- fin modal-->

<script type="text/javascript">
    $(document).ready(function () {

        pageSetUp();

        var pagefunction = function () {

            localStorage.clear();

            var responsiveHelper_listing_utilisateurs = undefined;

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $('#listing_utilisateurs').dataTable({
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
                    if (!responsiveHelper_listing_utilisateurs) {
                        responsiveHelper_listing_utilisateurs = new ResponsiveDatatablesHelper($('#listing_utilisateurs'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_listing_utilisateurs.createExpandIcon(nRow);
                },
                "ajax": "modules/utilisateurs/ajax/iUtilisateur_listing.php",
                "drawCallback": function (oSettings) {
                    responsiveHelper_listing_utilisateurs.respond();
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
    function ouverture_utilisateurs_ajout() {
        $.ajax({
            url: 'modules/utilisateurs/modal/modal_utilisateurs_ajout.php',
            type: 'POST',
            data: '',
            dataType: 'html',
            success: function (contenu) {
                $('#utilisateurs_ajout .modal-content').html(contenu);
                $('#utilisateurs_ajout').modal('show');
            },
            error: function () {
                alert('erreur lors du retour JSON !');
            }
        });
    }

    function suppressionLigne(paramId) {
        $.SmartMessageBox({
            title: "Attention !",
            content: "Vous êtes sur le point de supprimer cet utilsateur, confirmer ?",
            buttons: '[Non][Oui]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Oui") {
                $.ajax({
                    url: 'modules/utilisateurs/ajax/iUtlisateur_suppression.php',
                    type: 'POST',
                    data: {'id': paramId},
                    dataType: 'html',
                    success: function (contenu) {
                        smallBox('Suppression', "L'utilisateur à correctement été supprimé.", 'success');
                        setTimeout(function () {
                            $('#listing_utilisateurs').DataTable().ajax.reload(null, false); // refresh la datable association
                        }, 500);
                    },
                    error: function () {
                        smallBox('Erreur', 'Une erreur est survenu dans la fonction suppressionLigne(paramId).', 'warning');
                    }
                });
            }
            if (ButtonPressed === "Non") {
                smallBox('Suppression', "L'utlisateur n'a pas été supprimé.", 'warning');
            }
        });
    }

</script>