<?php
    if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
        $sql = "SELECT ID, PHRASE, LANGUAGE FROM PHRASES WHERE USER_ID=" . $_SESSION['userId'] . " AND STATE=0 ORDER BY RAND() LIMIT 1";
        $dbRow = getSingleRowByStatement($sql);
        if (isset($dbRow)) {
            // TODO - Quickfix - must be changed
            $langTag = "german";
            if ($dbRow[2] == "de") {
                $langTag = "german";
            } else if ($dbRow[2] == "en") {
                $langTag = "english";
            }
?>
    <div id="phrase">
        <u>Please speak (<span id="phraseId"><?php echo $dbRow[0]; ?></span>) in <b><?php echo $langTag; ?></b> the text as it is displayed:</u>
        <ul>
            <li><span id="phraseContent"><?php echo $dbRow[1]; ?></span></li>
        </ul>
    </div>

    <div id="controls">
  	    <button id="recordButton" class="btn btn-outline-primary"><span class="oi oi-microphone" aria-hidden="true"></span> Start</button>
  	    <button id="stopButton" class="btn btn-outline-success"><span class="oi oi-check" aria-hidden="true"></span>Stop - File OK</button>
  	    <button id="cancelButton" class="btn btn-outline-danger"><span class="oi oi-x" aria-hidden="true"></span>Stop - File broken (record again)</button>
    </div>

  	<script src="js/recorder.js"></script>
  	<script src="js/app.js"></script>
<?php
        } else {
?>
        <div class="alert alert-danger" role="alert">
            No more content available
        </div>
<?php
        }
    }
?>

<span class="oi oi-icon-name" title="icon name" aria-hidden="true"></span>
