<?php

$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
    'authServerUrl'         => SYSTEM_KEYCLOAK_URL,
    'realm'                 => KEYCLOAK_REALM,
    'clientId'              => KEYCLOAK_CLIENT,
    'clientSecret'          => KEYCLOAK_CLIENT_SECRET,
    'redirectUri'           => SYSTEM_URL,
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    session_destroy();
    redirectToUrl(SYSTEM_URL);
} else {

    if (!isset($_SESSION['userLoggedIn'])) {
        // Try to get an access token (using the authorization coe grant)
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
        } catch (Exception $e) {
            session_destroy();
            redirectToUrl(SYSTEM_URL);
        }
    } else {
        try {
            $token = $provider->getAccessToken('refresh_token', ['refresh_token' => $_SESSION['refreshToken']]);
        } catch (Exception $e) {
            session_destroy();
            redirectToUrl(SYSTEM_URL);
        }
    }

    try {
        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);
    } catch (Exception $e) {
        session_destroy();

        // Redirect to keycloak to logout
        redirectToUrl($provider->getLogoutUrl());
    }

    // Copy Data to session
    $_SESSION['userLoggedIn'] = true;
    $_SESSION['keycloakUserId'] = $user->getId();
    if (in_array(KEYCLOAK_ROLE_ADMIN, $user->toArray()['groups'])) {
        $_SESSION['userLevel'] = 2;
    } else if (in_array(KEYCLOAK_ROLE_USER, $user->toArray()['groups'])) {
        $_SESSION['userLevel'] = 1;
    } else {
        session_destroy();
        redirectToUrl(SYSTEM_URL);
    }
    $_SESSION['userName'] = $user->getName();
    $_SESSION['userLoginName'] = $user->toArray()['preferred_username'];
    $_SESSION['refreshToken'] = $token->getRefreshToken();
    $_SESSION['currentToken'] = $token->getToken();

    // If user = speaker - check if exists - otherwise create
    if (!checkUniqueExist("USERS", "USERNAME", preventInject($_SESSION['userLoginName']))) {
        $sqlStatement = "INSERT INTO USERS (USERNAME, TYPE) VALUES (";
        $sqlStatement .= "'" . preventInject($_SESSION['userLoginName']) . "', 1)";
        $saveSuccessful = db_insertStatement($sqlStatement);
    }

    $_SESSION['userId'] = getSingleValueByStatement("SELECT ID FROM USERS WHERE USERNAME='" . $_SESSION['userLoginName'] . "' AND TYPE=1");
}

if (isset($_POST['logout'])) {
    session_destroy();
    session_start();

    // Redirect to keycloak to logout
    redirectToUrl($provider->getLogoutUrl());
}

?>