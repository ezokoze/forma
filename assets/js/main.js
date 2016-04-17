/**
 * Scripts globale
 */


/**
 * @description Affiche une petite notification
 *
 * use : smallBox('Information', 'Votre saisie a été acceptée', 'success', '3000');
 *
 * @param title
 * @param content
 * @param type
 * @param timeout
 */
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

/**
 * @description Affiche une notification de confirmation en estompant l'écran de l'utilisateur
 *
 * @param titre
 * @param texte
 * @param lien
 */
function supprimerConfirmation(titre, texte, lien) {
    var texte = ((texte == undefined) || (texte == '')) ? 'Voulez-vous vraiment supprimer cet enregistrement ?' : texte;
    $.SmartMessageBox({
        title  : "<i class='fa fa-times txt-color-red'></i> Confirmer la <span class='txt-color-red''>suppression</span> " + titre + " ?",
        content: texte,
        buttons: '[Non][Oui]'
    }, function (ButtonPressed) {
        if (ButtonPressed === "Oui") {
            document.location.href = "index.php?p=" + lien;
        }
    });
}


/**
 * @description Modifie la visibilité
 *
 * @param visible
 * @param id
 * @param lien
 * @param dataId
 */
function modifierVisibilite(visible, id, lien, dataId) {
    $.ajax({
        url     : lien,
        type    : 'POST',
        data    : {'visible': visible, 'id': id},
        dataType: 'json',
        success : function (json) {
            if (json.retour) {
                var elem = $('[data-' + dataId + '-id="' + json.id + '"]');

                elem.find('span[onclick]').attr('onclick', json.onclick);
                if (json.checked) {
                    elem.find('input[type="checkbox"]').prop('checked', true);
                } else {
                    elem.find('input[type="checkbox"]').prop('checked', false);
                }

                smallBox('Information', json.message, 'success');
            } else {
                smallBox('Information', json.message + '<br>' + json.messageSql, 'error');
            }
        },
        error   : function () {
            smallBox('Information', 'Erreur lors du retour des données', 'error');
        }
    });
}


/**
 * @description Converti une chaine en une chaine URL correcte
 *
 * http://stackoverflow.com/a/5782563
 *
 * @param str
 * @returns {string|*}
 */
function slugify(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    var to = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}


/**
 * @description Affiche/Cache l'écran de chargement
 *
 * @param bool
 * @param texte
 */
function chargement(bool, txt) {
    var chargement = $('#chargement');
    var texte = (txt != '') ? txt : 'Chargement...';

    chargement.find('#chargement-text').html(texte);

    if (bool) {
        chargement.show();
    } else {
        chargement.hide();
    }
}

/**
 * @description Ajoute un élément (ligne)
 *
 * @param elem
 */
function addItem(elem) {
    var plus = $(elem).parent().parent();
    plus.clone().insertAfter(plus).removeClass('first').find('input').val('');
}

/**
 * @description Supprime un élément (ligne)
 *
 * @param elem
 */
function removeItem(elem) {
    var moins = $(elem).parent().parent();
    moins.remove();
}

/**
 * @description Affiche un message d'avertissement en cas de non sauvegarde d'un formulaire.
 *
 * @param lien
 */
function avertissementNonSauvegarde(lien) {
    $.SmartMessageBox({
        title  : "<i class='fa fa-warning txt-color-orange'></i> Confirmer la <span class='txt-color-orange''>perte</span> de vos modifications non sauvegardées ?",
        content: "Toutes les modifications de cette page non sauvegardées seront définitivement effacées.",
        buttons: '[Non][Oui]'
    }, function (ButtonPressed) {
        if (ButtonPressed === "Oui") {
            window.location.href = lien;
        }
    });
}



function avertissementNonSauvegardeAlt() {
    $.SmartMessageBox({
        title  : "<i class='fa fa-warning txt-color-orange'></i> Confirmer la <span class='txt-color-orange''>perte</span> de vos modifications non sauvegardées ?",
        content: "Toutes les modifications de ce formulaire non sauvegardées seront perdues.",
        buttons: '[Non][Oui]'
    }, function (ButtonPressed) {
        if (ButtonPressed === "Oui") {
            $( "#lien_annonce").click();
            $( "#lien_photos" ).attr("href", "#photos").click();
            return true;
        }
        else
        {
            $( "#lien_photos" ).attr("href", "");
            $( "#lien_annonce").click();
            return false;
        }
    });
}

/**
 * @description Obtenir les coordonées de Google Maps par rapport à l'adresse
 *
 * @param latitude
 * @param longitude
 * @param adresse
 */
function getCoordonnees(latitude, longitude, adresse) {
    GMaps.geocode({
        address : adresse,
        callback: function (results, status) {
            if (status == 'OK') {
                var latlng = results[0].geometry.location;
                $('#' + latitude).val(latlng.lat());
                $('#' + longitude).val(latlng.lng());
            }
        }
    });
}

/**
 * @description Gestion de la déconnexion de l'application
 */
function deconnexion() {
    $.SmartMessageBox({
        title  : "<i class='fa fa-sign-out txt-color-orangeDark'></i> Se déconnecter <span class='txt-color-orangeDark'><strong>" + $("#show-shortcut").text() + "</strong></span> ?",
        content: "Vous êtes sur le point de vous déconnecter",
        buttons: '[Non][Oui]'
    }, function (ButtonPressed) {
        if (ButtonPressed === "Oui") {
            window.location.href = $("#deconnexion").data('href');
        }
    });
}