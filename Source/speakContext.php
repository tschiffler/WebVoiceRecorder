<?php
    if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
        $sql = "SELECT ID, PHRASE FROM PHRASES WHERE USER_ID=" . $_SESSION['userId'] . " AND STATE=0";
        $dbRow = getSingleRowByStatement($sql);
        if (isset($dbRow)) {
?>
    <div id="phrase">
        <b>Please speek: (<span id="phraseId"><?php echo $dbRow[0]; ?></span>):</b> <span id="phraseContent"><?php echo $dbRow[1]; ?></span>
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
