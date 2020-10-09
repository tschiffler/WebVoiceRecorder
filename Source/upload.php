<?php

    // Check if Parameters are in right format
    $phraseId = $_GET['phraseId'];
    $userId = $_GET['userId'];
    if (!is_numeric($phraseId) || !is_numeric($userId)) {
        // Params not Numeric - stop Script
        exit();
    }

    // Start Session
    session_start();

    // Check if User is Logged in and if User equals given user
    if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
        if ($_SESSION['userId'] != $userId) {
            // Wrong User-ID Given
            exit();
        }
    } else {
        // User is not logged in
        exit();
    }

    // Access Database
    require_once 'config.inc.php';
    require_once './functions/database.php';
    connectDatabase(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check if given File is from the current User
    $sql = "SELECT * FROM PHRASES WHERE ID=" . preventInject($phraseId) . " AND USER_ID=" . preventInject($userId);
    if (!checkUniqueExistStatement($sql)) {
        exit();
    }

    // create Filename
    $input = $_FILES['audio_data']['tmp_name'];
    $output = "upload/" . $phraseId . ".wav";

    // move file
    if (move_uploaded_file($input, $output)) {
        $sqlStatement = "UPDATE PHRASES SET STATE=1 WHERE ID=" . preventInject($phraseId);
        db_Statement($sqlStatement);
    }

?>