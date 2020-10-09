<?php

 function isFieldSet ($field) {
 	if (!isset($field) || (strlen($field) == 0)) {
 		return false;
 	} else {
 		return isFieldContentValid($field);
 	}
 }

 function isFieldContentValid($field) {
 	if (isset($field) || (strlen($field) > 0)) {
 		if ((strpos($field, "<?") > -1) || (strpos($field, "SELECT * FROM") > -1)) {
 			return false;
 		}
 	}

 	return true;
 }

?>