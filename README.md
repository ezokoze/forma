# FORMA APPLICATION WEB
Application pour les utilisateurs de la maison des ligues permettant leur(s) inscription(s) aux différentes formation et permet l'administration des formations à des utilisateurs possédant les pouvoirs d'admnistrateur.

>Pour plus d'informations sur les classes utilisés vous pouvez retrouver la [documentation](http://www.francois-garcia.ws/formaweb_doc/).

## Interface de connexion

Interface de connexion simple permettant la saisie de l'identifiant (e-amil) et mot de passe de l'utilisateur.
Le mot de passe utilise le protocole de cryptage **SHA1**.

![alt tag](https://i.gyazo.com/41ab36ecc2679217231fdd3fb64c5ed8.png)


## Menu

Cette application dispose d'un menu après connexion, permettant à l'utilisateur de choisir l'action attendue.
L'utilisateur a le choix entre consulter les *stages de formations à venir*, *consulter toutes les formations* disponibles, *ajouter des associations ou les modifier* et pour finir *ajouter ou modifier des utilisateurs*.

## Consultation d'une rubrique

De manière général l'utilisateur une fois connecté dipose d'un menu lui permettant l'accès à un pannel de fonction.

![alt tag](https://i.gyazo.com/ee9f56dcb4ea62ddb6b0e0536fb80065.png)

Ainsi l'utilisateur dispose de tableau permettant la recherche ou la consultation de n'importe lesquels de ces catégories.

``` c#
dbConnect.listViewStagesFormations(query, listViewStagesFormations);
```

Affichage du code javascript permettant le remplissage d'une Datatable avec un appel Ajax.
``` javascript
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
```

## Ajout

Afin d'ajouter une formation ou un stage l'utilisateur doit-être en premier lieu un administrateur.
Une fois l'utilisateur connecté lorsqu'il se rend sur une catégorie il disposera toujours d'un bouton *Créer un/une [...]*.
Si l'utilisateur clique sur ce bouton il se verra apparaître à l'écran un modal permettant l'ajout des données correspondantes à la catégorie.

![alt tag](https://i.gyazo.com/1a661a2ec2d76ae6b553a61283f909d8.png)

Une fois la création ajoutée une notification d'ajout apparaîtra en haut à droite de l'écran.

## Modification

Afin de modifier n'importe quelle ligne de la datatable, deux boutons sont à la disposition de l'utilisateur, un bouton modifier (bleu) et un bouton permettant la suppression de ligne (rouge)

![alt tag](https://i.gyazo.com/606e963730ac6f446f8d8148e0a4ff0c.png)

En cliquant sur le bouton de modification l'utilisateur fait apparaître un modal lui présentant les mêmes champs qu'au moment de la création d'une de ces lignes à la différence que les champs sont pré-remplie exécute une simple requête SQL de type UPDATE

Voici un exemple de modal de modification : 

![alt tag](https://i.gyazo.com/d148628de3c3f9db9052a2af160dc245.png)

Une fois la modification effectué lorsque l'utilisateur cliquera sur le bouton *Modifier !* une notification d'erreur ou de succès apparaîtra en haut à droite sur l'écran de l'utilisateur.

## Suppression 

Pour supprimer une ligne, l'utilisateur dispose d'un bouton de suppression dans la colonne la plus à droite de la datatable, il s'agit d'un bouton rouge, une fois celui-ci pressé un message de confirmation apparaîtra à l'écran de l'utilisateur. Si celui-ci confirme la ligne correspondante sera supprimé et la datatable automatiquement rafraichit.

## Notification

Afin de permettre à l'utilisateur une connaissance permanente sur le succès ou des erreurs durant les ajouts ou les modifications j'ai mis en place un système de notification.
Le code permettant l'apparition de celles-ci est simple.

Dans le cas d'une erreur : 

``` javascript
smallBox('Inscription', 'Utilisateurs correctement inscrit à la formation.', 'error');
```

La fonction smallBox possédant le code suivant : 

``` javascript
function smallBox(title, content, type, timeout) {
    var title = ((title == undefined) || (title == '')) ? 'Information' : title;
    var content = ((content == undefined) || (content == '')) ? 'Nouvelle information' : content;
    var timeout = ((timeout == undefined) || (timeout == '')) ? '4000' : timeout;
    switch (type) {
        case 'success':
            var color = '#739E73';
            var icon = 'fa fa-check';
            break;
        case 'warning':
            var color = '#C79121';
            var icon = 'fa fa-exclamation-circle';
            break;
        case 'error':
            var color = '#C46A69';
            var icon = 'fa fa-times';
            break;
        default:
            // Info
            var color = '#3276B1';
            var icon = 'fa fa-info-circle';
            break;
    }

    $.smallBox({
        title  : title,
        content: content,
        color  : color,
        timeout: timeout,
        icon   : icon
    });
}
```

