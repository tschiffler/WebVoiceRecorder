<?php

  // Database-Host
 define('DB_HOST', 'localhost');

 // Local
 define('DB_NAME', 'soundrecorder');
 define('DB_USER', 'soundrecorder');
 define('DB_PASSWORD', 'soundrecorder');

 define ('MYSQL_PASSWORD_SALT', 'ChangeMeInBasedataAndConfig');

 // LOGIN Config
 define('LOGINMODE', 'KEYCLOAK'); // Possible Modes - "LOCAL" -> local Database, "KEYCLOAK" Keycloak instance
 define('SYSTEM_URL', '<ownSystemUrl>');
 define('SYSTEM_KEYCLOAK_URL', '<urlToKeycloakInstanceIncludingPossibleSubDir>');
 define('KEYCLOAK_REALM', '<NameOfOwnRealm>');
 define('KEYCLOAK_CLIENT', '<NameOfClient>');
 define('KEYCLOAK_CLIENT_SECRET', '<ClientSecret>');
 define('KEYCLOAK_ROLE_ADMIN', '<RoleThatWillBeAssigendToAdminusers>'); // VOICERECORDER_ADMIN
 define('KEYCLOAK_ROLE_USER', '<RoleThatWillBeAssignedToSpeakers>'); // VOICERECORDER_SPEAKER
?>