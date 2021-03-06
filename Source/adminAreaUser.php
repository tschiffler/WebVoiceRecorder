<h2>Usermanagement</h2>

<?php
    if (isset($_POST['createUserRequest']) || isset($_POST['saveUser']) || isset($_POST['editUserId'])) {
        if (isset($_POST['editUserId'])) {
?>
        <h3>Edit User</h3>
<?php
        } else {
?>
        <h3>Add User</h3>
<?php
        }
        $invalidUsername = false;
        $invalidPassword = false;
        $userSaved = false;

        if (isset($_POST['saveUser'])) {
            if (!isset($_POST['editUserId'])) {
                if (!isFieldSet($_POST['username']) || checkUniqueExist("USERS", "USERNAME", preventInject($_POST['username']))) {
                    $invalidUsername = true;
                }
            }

            if (isLocalUsermanagementEnabled() &&
                (!isFieldSet($_POST['pwd1']) ||
                !isFieldSet($_POST['pwd2']) ||
                ($_POST['pwd1'] != $_POST['pwd2']))) {
                $invalidPassword = true;
            }

            if (!$invalidUsername && !$invalidPassword) {
                if (isset($_POST['editUserId'])) {
                    $sqlStatement = "UPDATE USERS SET ";
                    if (isLocalUsermanagementEnabled()) {
                        $sqlStatement .= "PASSWORD = AES_ENCRYPT('" . $_POST['pwd1'] . "', '" . MYSQL_PASSWORD_SALT . "'), ";
                    }
                    $sqlStatement .= "TYPE = " . $_POST['usergroup'];
                    $sqlStatement .= " WHERE ID = " . $_POST['editUserId'];

                    $saveSuccessful = db_Statement($sqlStatement);
                } else {
                    // create new user
                    $sqlStatement = "INSERT INTO USERS (USERNAME, PASSWORD, TYPE) VALUES (";
                    $sqlStatement .= "'" . preventInject($_POST['username']) . "', ";
                    if (isLocalUsermanagementEnabled()) {
                        $sqlStatement .= "AES_ENCRYPT('" . $_POST['pwd1'] . "', '" . MYSQL_PASSWORD_SALT . "'), ";
                    } else {
                        $sqlStatement .= "null, ";
                    }

                    $sqlStatement .= $_POST['usergroup'] . ")";

                    $saveSuccessful = db_insertStatement($sqlStatement);
                }

                if ($saveSuccessful) {
                    $userSaved = true;
?>
                <div class="alert alert-success" role="alert">
                    User successful saved
                </div>
<?php
                } else {
?>
                <div class="alert alert-danger" role="alert">
                    User could not be saved
                </div>
<?php
                }
            }
        }

        if (!$userSaved) {
?>
        <form method="post">
<?php
            if (isset($_POST['editUserId'])) {
                $existingUserData = getSingleRowByStatement("SELECT ID, USERNAME, TYPE FROM USERS WHERE ID=" . $_POST['editUserId']);
                $_POST['username'] = $existingUserData[1];
                $_POST['usergroup'] = $existingUserData[2];
?>
            <input type="hidden" name="editUserId" value="<?php echo $_POST['editUserId']; ?>" />
<?php
            }

?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control <?php if ($invalidUsername) echo 'is-invalid'; ?>" name="username" id="username" <?php if (isset($_POST['editUserId'])) echo "disabled"; ?> value="<?php echo $_POST['username']; ?>">
                <?php if ($invalidUsername) { ?>
                    <div class="invalid-feedback">
                        Username invalid
                    </div>
                <?php } ?>
            </div>
            <?php
                if (isLocalUsermanagementEnabled()) {
            ?>
            <div class="form-group">
                <label for="usergroup">Group:</label>
                <select class="form-control" id="usergroup" name="usergroup">
                    <option value="1" <?php if (isset($_POST['usergroup']) && ($_POST['usergroup'] == 1)) echo "selected"; ?>>Speaker</option>
                    <option value="2" <?php if (isset($_POST['usergroup']) && ($_POST['usergroup'] == 2)) echo "selected"; ?>>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pwd1">Password:</label>
                <input type="password" class="form-control <?php if ($invalidPassword) echo 'is-invalid'; ?>" name="pwd1" id="pwd1" value="<?php echo $_POST['pwd1']; ?>">
                <?php if ($invalidPassword) { ?>
                    <div class="invalid-feedback">
                        Password invalid
                    </div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="pwd2">Password (repeat):</label>
                <input type="password" class="form-control" name="pwd2" id="pwd2" value="<?php echo $_POST['pwd2']; ?>">
            </div>
            <?php
                } else {
            ?>
                <input type="hidden" name="usergroup" value="1" />
            <?php
                }
             ?>
            <button type="submit" name="saveUser" class="btn btn-outline-primary mb-2"><span class="oi oi-check" aria-hidden="true"></span> Save user</button>
        </form>
<?php
        }
    } else {
?>

<script type="text/javascript">
    function editUser(userId) {
        var form = $('<form method="post">' +
          '<input type="hidden" name="editUserId" value="' + userId + '" />' +
          '</form>');
        $('body').append(form);
        form.submit();
    }
</script>

<h3>existing users</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Group</th>
      <th scope="col">Open Phrases</th>
      <th scope="col">Spoken Phrases</th>
    </tr>
  </thead>
  <tbody>
<?php
    $result = selectFromTable("SELECT ID, USERNAME, TYPE FROM USERS ORDER BY ID");
    while ($zeile = mysqli_fetch_row($result)) {
?>

    <tr onclick="editUser(<?php echo $zeile[0]; ?>)">
      <th scope="row"><?php echo $zeile[0]; ?></th>
      <td><?php echo $zeile[1]; ?></td>
      <td><?php if ($zeile[2] == 2) echo "Admin"; else echo "Speaker"; ?></td>
      <td><?php if ($zeile[2] == 2) echo "-"; else echo getSingleValueByStatement("SELECT COUNT(*) FROM PHRASES WHERE USER_ID=" . $zeile[0]. " AND STATE=0"); ?></td>
      <td><?php if ($zeile[2] == 2) echo "-"; else echo getSingleValueByStatement("SELECT COUNT(*) FROM PHRASES WHERE USER_ID=" . $zeile[0]. " AND STATE=1"); ?></td>
    </tr>

<?php
    }

?>
  </tbody>
</table>

<form method="post">
    <button type="submit" name="createUserRequest" class="btn btn-outline-primary mb-2"><span class="oi oi-plus" aria-hidden="true"></span> Add new User</button>
</form>

<?php
    }
?>