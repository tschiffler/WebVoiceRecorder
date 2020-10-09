<h2>Usermanagement</h2>

<?php
    if (isset($_POST['createUserRequest']) || isset($_POST['saveUser'])) {
?>
        <h3>neuen Benutzer anlegen</h3>
<?php
        $invalidUsername = false;
        $invalidPassword = false;
        $userSaved = false;

        if (isset($_POST['saveUser'])) {

            if (!isFieldSet($_POST['username']) || checkUniqueExist("USERS", "USERNAME", preventInject($_POST['username']))) {
                $invalidUsername = true;
            }
            if (!isFieldSet($_POST['pwd1']) ||
                !isFieldSet($_POST['pwd2']) ||
                ($_POST['pwd1'] != $_POST['pwd2'])) {
                $invalidPassword = true;
            }

            if (!$invalidUsername && !$invalidPassword) {
                // Do Persist
                $sqlStatement = "INSERT INTO USERS (USERNAME, PASSWORD, TYPE) VALUES (";
                $sqlStatement .= "'" . preventInject($_POST['username']) . "', ";
                $sqlStatement .= "AES_ENCRYPT('" . $_POST['pwd1'] . "', '" . MYSQL_PASSWORD_SALT . "'), ";
                $sqlStatement .= $_POST['usergroup'] . ")";

                if (db_insertStatement($sqlStatement)) {
                    $userSaved = true;
?>
                <div class="alert alert-success" role="alert">
                    Der Benutzer wurde erfolgreich gespeichert
                </div>
<?php
                } else {
?>
                <div class="alert alert-danger" role="alert">
                    Beim Speichern des Benutzers ein ein Fehler aufgetreten.
                </div>
<?php
                }
            }
        }

        if (!$userSaved) {
?>

        <form method="post">
            <div class="form-group">
                <label for="username">Benutzername:</label>
                <input type="text" class="form-control <?php if ($invalidUsername) echo 'is-invalid'; ?>" name="username" id="username" value="<?php echo $_POST['username']; ?>">
                <?php if ($invalidUsername) { ?>
                    <div class="invalid-feedback">
                        Benutzername ungültig
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="usergroup">Benutzergruppe:</label>
                <select class="form-control" id="usergroup" name="usergroup">
                    <option value="1">Sprecher</option>
                    <option value="2">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pwd1">Passwort:</label>
                <input type="password" class="form-control <?php if ($invalidPassword) echo 'is-invalid'; ?>" name="pwd1" id="pwd1" value="<?php echo $_POST['pwd1']; ?>">
                <?php if ($invalidPassword) { ?>
                    <div class="invalid-feedback">
                        Passwort ungültig
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="pwd2">Passwort (Wiederholung):</label>
                <input type="password" class="form-control" name="pwd2" id="pwd2" value="<?php echo $_POST['pwd2']; ?>">
            </div>

            <button type="submit" name="saveUser" class="btn btn-outline-primary mb-2">Benutzer speichern</button>
        </form>
<?php
        }
    } else {
?>
<h3>verfügbare Benutzer</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Benutzername</th>
      <th scope="col">Level</th>
      <th scope="col">anzahl offener Phrases</th>
    </tr>
  </thead>
  <tbody>
<?php
    $result = selectFromTable("SELECT ID, USERNAME, TYPE FROM USERS ORDER BY ID");
    while ($zeile = mysqli_fetch_row($result)) {
?>

    <tr>
      <th scope="row"><?php echo $zeile[0]; ?></th>
      <td><?php echo $zeile[1]; ?></td>
      <td><?php if ($zeile[2] == 2) echo "Admin"; else echo "Sprecher"; ?></td>
      <td><?php if ($zeile[2] == 2) echo "-"; else echo getSingleValueByStatement("SELECT COUNT(*) FROM PHRASES WHERE USER_ID=" . $zeile[0]. " AND STATE=0"); ?></td>
    </tr>

<?php
    }

?>
  </tbody>
</table>

<form method="post">
    <button type="submit" name="createUserRequest" class="btn btn-outline-primary mb-2">Neuen User anlegen</button>
</form>

<?php
    }
?>