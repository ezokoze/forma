<?php require_once("inc/init.php"); ?>

<button type="button" class="well" onclick="ouverture_associations_ajout();"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Créer une association
</button>

<!-- modal-->
<div class="modal fade" id="associations_ajout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div> <!-- fin modal-->

<script type="text/javascript">

    pageSetUp();

    var pagefunction = function () {

        localStorage.clear();

    };
    function ouverture_associations_ajout() {
        $.ajax({
            url: './ajax/modal_associations_ajout.php',
            type: 'POST',
            data: '',
            dataType: 'html',
            success: function (contenu) {
                $('#associations_ajout .modal-content').html(contenu);
                $('#associations_ajout').modal('show');
            },
            error: function () {
                alert('erreur lors du retour JSON !');
            }
        });
    }

    function ouvertureModification_utilisateur(paramId) {
        window.location = './#ajax/modification_utilisateur.php?id=' + paramId ;
    }

    function suppressionLigne(paramId) {
        $.SmartMessageBox({
            title: "Attention !",
            content: "Vous êtes sur le point de supprimer cet utilsateur, confirmer ?",
            buttons: '[Non][Oui]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Oui") {
                $.ajax({
                    url: './php/modal/modal_suppression_utilisateur.php',
                    type: 'POST',
                    data: {'id': paramId},
                    dataType: 'html',
                    success: function (contenu) {
                        smallBox('Suppression', "L'utilisateur à correctement été supprimé.", 'success');
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