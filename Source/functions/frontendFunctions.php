<?php

 function redirectToUrl ($targetUrl) {
     header("location: " . $targetUrl);
     exit;
 }

?>