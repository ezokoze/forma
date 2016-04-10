<?php require_once("inc/init.php"); ?>

<button type="button" class="well" onclick="ouvertureAjout_utilisateur();"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Créer un nouveau stage
</button>

<!-- modal-->
<div class="modal fade" id="modal_ajoute_utilisateur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div> <!-- fin modal-->


<!-- row -->
<div class="row">

    <!-- nouveau widget -->
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <!-- id du widget -->
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false"
             data-widget-fullscreenbutton="false">

            <header>
                <span class="widget-icon"> <i class="fa fa-graduation-cap"></i> </span>
                <h2>Stages</h2>
            </header>
            <!-- widget div-->
            <div>
                <!-- edit box du widget -->
                <div class="jarviswidget-editbox">

                </div>
                <!-- fin edit box du widget -->
                <!-- contenu widget -->
                <div class="widget-body no-padding">
                    <form id="tableau">
                        <table id="listing_intervenants" class="table table-striped table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Local</th>
                                <th>Téléphone mobile</th>
                                <th>Email</th>
                                <th>Modifications</th>
                            </tr>
                            </thead>
                        </table>
                    </form>

                </div>
                <!-- fin contenu widget -->
            </div>
            <!-- fin widget div -->
        </div>
        <!-- fin widget -->
    </article>
    <!-- FIN END -->
</div>
<!-- fin row -->


<script type="text/javascript">

    pageSetUp();

    var pagefunction = function () {

        localStorage.clear();

        var responsiveHelper_listing_intervenants = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };


        $('#listing_intervenants').dataTable({
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
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!responsiveHelper_listing_intervenants) {
                    responsiveHelper_listing_intervenants = new ResponsiveDatatablesHelper($('#listing_intervenants'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_listing_intervenants.createExpandIcon(nRow);
            },
            "ajax": "./php/iListe_utilisateurs.php",
            "drawCallback": function (oSettings) {
                responsiveHelper_listing_intervenants.respond();
            },
            "language": {
                "url": "./data/french_trad_datatables.json"
            }
        });
    };

    function ouvertureAjout_utilisateur() {
        $.ajax({
            url: './php/modal/modal_ajout_utilisateur.php',
            type: 'POST',
            data: '',
            dataType: 'html',
            success: function (contenu) {
                $('#modal_ajoute_utilisateur .modal-content').html(contenu);
                $('#modal_ajoute_utilisateur').modal('show');
            },
            error: function () {
                alert('erreur lors du retour JSON !');
            }
        });
    }

    function ouvertureModification_utilisateur(paramId) {
        window.location = './#ajax/modification_utilisateur.php?id=' + paramId;
    }

    function suppressionLigne(paramId) {
        $.SmartMessageBox({
            title: "Attention !",
            content: "Vous êtes sur le point de supprimer cet utilsateur, confirmer ?",
            buttons: '[Non][Oui]'
        }, function (ButtonPressed) {
            console.log(paramId);
            if (ButtonPressed === "Oui") {
                $.ajax({
                    url: './php/modal/modal_suppression_utilisateur.php',
                    type: 'POST',
                    data: {'id': paramId},
                    dataType: 'html',
                    success: function (contenu) {
                        smallBox('Suppression', "L'utilisateur à correctement été supprimé.", 'success');
                        setTimeout(function () {
                            $('#listing_intervenants').DataTable().ajax.reload(null, false);
                        }, 500);
                    },
                    error: function () {
                        smallBox('Erreur', 'Une erreur est survenu dans la fonction suppressionLigne(paramId).', 'warning');
                    }
                });
            }
            if (ButtonPressed === "Non") {
                smallBox('Suppression', "L'équipement n'a pas été supprimé.", 'warning');
            }
        });
    }

    loadScript("js/plugin/datatables/jquery.dataTables.min.js", function () {
        loadScript("js/plugin/datatables/dataTables.colVis.min.js", function () {
            loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function () {
                loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function () {
                    loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
                });
            });
        });
    });


</script>