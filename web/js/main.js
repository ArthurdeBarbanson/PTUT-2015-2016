/**
 * Created by antoine on 31/05/2016.
 */
function disableScreen() {
    $("#backgroundDisable").show();
}

function enableScreen() {
    $("#backgroundDisable").hide();
}

$(document).ready(function () {
    if ($('#erreur-message').length > 0) {
        disableScreen();
    }

    if ($('#success-message').length > 0) {
        $('#success-message').delay(3000).fadeOut();
    }

    if ($('#info-message').length > 0) {
        $('#info-message').delay(3000).fadeOut();
    }
});

