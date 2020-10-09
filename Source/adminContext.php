<?php
    if (isset($_POST['manageUsers'])) {
        $_SESSION['adminMode'] = "USER";
    } else if (isset($_POST['manageContent'])) {
        $_SESSION['adminMode'] = "CONTENT";
    }

    if (!$_SESSION['adminMode']) {
        $_SESSION['adminMode'] = "CONTENT";
    }
?>

<form method="post">
    <div class="row justify-content-center">
        <div class="col-4">
            <button type="submit" name="manageUsers" class="btn btn-primary <?php if ($_SESSION['adminMode'] == "USER") echo active; ?>">User-Management</button>
        </div>
        <div class="col-4">
            <button type="submit" name="manageContent" class="btn btn-primary <?php if ($_SESSION['adminMode'] == "CONTENT") echo active; ?>">Content-Management</button>
        </div>
    </div>
</form>

<br/>

<?php

    if ($_SESSION['adminMode'] == "USER") {
        require_once './adminAreaUser.php';
    } else if ($_SESSION['adminMode'] == "CONTENT") {
        require_once './adminAreaContent.php';
    }

?>