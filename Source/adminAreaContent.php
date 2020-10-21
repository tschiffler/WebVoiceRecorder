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

This function can be used to assign new content to individual users which they have to speak.<br/>
<u>Usage:</u><br/>
<ul>
    <li>Select users who should speak the text</li>
    <li>Select the language in which the texts should be spoken</li>
    <li>Select the file with the texts (text file, 1 utterance per line)</li>
    <li>perform upload</li>
</ul>
<br/>

<h3>add new content</h3>
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
        <div class="col-3">selectd users</div>
        <div class="col-9">
<?php

    $result = selectFromTable("SELECT ID, USERNAME FROM USERS WHERE TYPE=1");

    while ($zeile = mysqli_fetch_row($result)) {
?>
        <input type="checkbox" name="selectedUser_<?php echo $zeile[0]; ?>" value="true"> <?php echo $zeile[1]; ?> - open phrases: <?php echo getSingleValueByStatement("SELECT COUNT(*) FROM PHRASES WHERE USER_ID=" . $zeile[0]. " AND STATE=0"); ?><br/>
<?php
    }

?>
        </div>
    </div>
    <div class="row">
        <div class="col-3">language</div>
        <div class="col-9">
            <select name="language">
                <option value="de">german</option>
                <option value="en">english</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-3">File with content</div>
        <div class="col-9">
            <input name="contentFile" type="file" accept="text/*">
        </div>
    </div>
    <button type="submit" name="doUpload" class="btn btn-outline-primary mb-2"><span class="oi oi-cloud-upload" aria-hidden="true"></span> do upload</button>
</form>


<?php
    if (isset($_POST['doExport'])) {
        $result = selectFromTable("SELECT ID, USER_ID, LANGUAGE, PHRASE FROM PHRASES WHERE STATE=1");
        $fileContent = "ID;USER-ID;LANG;PHRASE\n";
        while ($zeile = mysqli_fetch_row($result)) {
            $fileContent .= $zeile[0] . ";" . $zeile[1] . ";" . $zeile[2] . ";" . $zeile[3] . "\n";
        }
        if (file_put_contents("upload/export.csv", $fileContent)) {
?>
        <div class="alert alert-success" role="alert">
            Export to upload/export.csv successful
        </div>
<?php
        } else {
?>
        <div class="alert alert-danger" role="alert">
            Export could not be created
        </div>
<?php
        }
    }
?>

<br/>
<h3>export content</h3>
To export the spoken content to a csv-file just use the following button.<br/><br/>
<form method="post" enctype="multipart/form-data">
    <button type="submit" name="doExport" class="btn btn-outline-primary mb-2"><span class="oi oi-cloud-download" aria-hidden="true"></span> do generate exportfile</button>
</form>
<?php
    }
?>