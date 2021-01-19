<?php error_reporting(E_ERROR | E_PARSE); ?>
<?php session_start(); ?>
<?php
    require_once 'config.inc.php';
    require_once './functions/database.php';
    require_once './functions/validateFunctions.php';
    require_once './functions/frontendFunctions.php';

    require  './vendor/autoload.php';

    connectDatabase(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Web Voice Recorder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- fonts -->
    <link href="open-iconic/font/css/open-iconic-bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <h1>Web Voice Recorder</h1>
    <div class="container-sm">
<?php
    // check if Login or Logout is Executed
    require_once './functions/loginFunctions.php';

    if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
        require_once './userArea.php';

        if ($_SESSION['userLevel'] == 1) {
            if ($_SESSION['userDataApproval'] != 1) {
                if (isset($_POST['dataPrivacyOK'])) {
                    db_insertStatement("INSERT INTO USERS_DATA_APPROVAL (USER_ID, APPROVAL_DATE) VALUES (" . $_SESSION['userId'] . ", now())");
                    $_SESSION['userDataApproval'] = 1;
                } else {
                    // Ask User for Data-Approval
                    require_once './dataApprovalCheck.php';
                }
            }

            if ($_SESSION['userDataApproval'] == 1) {
                // Let User Speak
                require_once './speakContext.php';
            }
        } else {
            // Show Admin-Area
            require_once './adminContext.php';
        }
    } else {
        // No User Logged-In -> Show LoginForm
        require_once './loginForm.php';
    }
?>
    </div>
  </body>
</html>
