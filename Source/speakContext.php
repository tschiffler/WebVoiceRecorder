<?php
    if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
        $sql = "SELECT ID, PHRASE FROM PHRASES WHERE USER_ID=" . $_SESSION['userId'] . " AND STATE=0";
        $dbRow = getSingleRowByStatement($sql);
        if (isset($dbRow)) {
?>
    <div id="phrase">
        <b>Bitte sprechen (<span id="phraseId"><?php echo $dbRow[0]; ?></span>):</b> <span id="phraseContent"><?php echo $dbRow[1]; ?></span>
    </div>

    <div id="controls">
  	    <button id="recordButton" class="btn btn-outline-success">Start</button>
  	    <button id="stopButton" class="btn btn-outline-danger" disabled>Stop</button>
    </div>

  	<script src="js/recorder.js"></script>
  	<script src="js/app.js"></script>
<?php
        } else {
?>
        <div class="alert alert-danger" role="alert">
            Keine weitere Daten für Voicerecording vorhanden
        </div>
<?php
        }
    }
?>
