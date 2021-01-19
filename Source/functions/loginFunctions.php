<?php
    function isLocalUsermanagementEnabled() {
        return LOGINMODE == 'LOCAL';
    }

    if (LOGINMODE == 'LOCAL') {
        require_once('loginFunctions_locale.php');
    } else if (LOGINMODE == 'KEYCLOAK') {
        require_once('loginFunctions_keycloak.php');
    } else {
        exit ("INVALID LOGINMODE");
    }
?>
