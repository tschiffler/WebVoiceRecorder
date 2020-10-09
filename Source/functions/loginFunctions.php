<?php
    if (isset($_POST['login'])) {
        $username = preventInject($_POST['username']);
        $password = preventInject($_POST['password']);

        // TODO prüfen ob SHA1 wirklich der richtige Weg ist
        $sql = "SELECT ID, TYPE FROM USERS WHERE USERNAME='" . $username . "' AND PASSWORD=AES_ENCRYPT('" . $password . "', '" . MYSQL_PASSWORD_SALT . "')";
        $userRow = getSingleRowByStatement($sql);
        if (isset($userRow)) {
            $_SESSION['userLoggedIn'] = true;
            $_SESSION['userId'] = $userRow[0];
            $_SESSION['userLevel'] = $userRow[1];
            $_SESSION['userName'] = $_POST['username'];
        } else {
?>
        <div class="alert alert-danger" role="alert">
            Logindaten fehlerhaft - bitte prüfen Sie Ihre Eingaben
        </div>
<?php
        }
    } else if (isset($_POST['logout'])) {
        session_destroy();
        session_start();
    }
?>