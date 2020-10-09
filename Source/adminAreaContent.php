<h2>Content-Management</h2>

<?php
    if (isset($_POST['doUpload'])) {
        $fileContent = file_get_contents($_FILES['contentFile']['tmp_name']);
        $rows = preg_split("%(\r|\n|\r\n)%", $fileContent);

        if (count($rows) > 1) {
?>
            Found <b><?php echo count($rows); ?></b> Rows (empty rows are removed during import)in uploaded File<br/>
<?php

            $result = selectFromTable("SELECT ID, USERNAME FROM USERS WHERE TYPE=1");
            $userFound = false;
            while ($zeile = mysqli_fetch_row($result)) {
                if (isset($_POST['selectedUser_' . $zeile[0]])) {
                    if ($_POST['selectedUser_' . $zeile[0]] == "true") {
                        $userFound = true;
?>
            Handle User <b><?php echo $zeile[1]; ?></b><br/>
<?php
                        foreach ($rows as $row) {
                            if (strlen(trim($row)) > 0) {
                                $sql = "INSERT INTO PHRASES (USER_ID, LANGUAGE, PHRASE) VALUES (" . $zeile[0] . ", '" . preventInject($_POST['language']) . "', '" . $row . "')";
                                db_insertStatement($sql);
                            }
                        }
                    }
                }
            }

            if (!$userFound) {
                $FAILURE = "NO USER SELECTED";
            }
        } else {
            $FAILURE = "No File given or file contains no rows";
        }
    }

    if (!isset($_POST['doUpload']) || isset($FAILURE)) {
?>

Über diese Funktion kann einzelnen Usern neuer Content zugewiesen werden welchen diese zu sprechen haben.<br/>
<u>Anwendung:</u><br/>
<ul>
    <li>Benutzer, welchen den Text sprechen sollen, auswählen</li>
    <li>Sprache, in welcher die Texte gesprochen werden sollen, auswählen</li>
    <li>Datei mit den Texten auswählen (Textdatei, je Zeile 1 Text)</li>
    <li>Upload durchführen</li>
</ul>
<br/>

<h3>Neuen Content hinzufügen</h3>
<?php
    if (isset($FAILURE)) {
?>
        <div class="alert alert-danger" role="alert">
            <?php echo $FAILURE; ?>
        </div>
<?php
    }
?>
<form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-3">gewählte Benutzer</div>
        <div class="col-9">
<?php

    $result = selectFromTable("SELECT ID, USERNAME FROM USERS WHERE TYPE=1");

    while ($zeile = mysqli_fetch_row($result)) {
?>
        <input type="checkbox" name="selectedUser_<?php echo $zeile[0]; ?>" value="true"> <?php echo $zeile[1]; ?> - offene Phrases: <?php echo getSingleValueByStatement("SELECT COUNT(*) FROM PHRASES WHERE USER_ID=" . $zeile[0]. " AND STATE=0"); ?><br/>
<?php
    }

?>
        </div>
    </div>
    <div class="row">
        <div class="col-3">Sprache</div>
        <div class="col-9">
            <select name="language">
                <option value="de">Deutsch</option>
                <option value="en">Englisch</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-3">Datei mit Texten</div>
        <div class="col-9">
            <input name="contentFile" type="file" accept="text/*">
        </div>
    </div>
    <button type="submit" name="doUpload" class="btn btn-outline-primary mb-2">Upload durchführen</button>
</form>

<?php
    }
?>