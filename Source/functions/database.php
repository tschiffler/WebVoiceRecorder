<?php
/**
 *
 * Created on 19.12.2006 by Thomas Schiffler
 *
 */

 function connectDatabase($db_host, $db_user, $db_password, $db_name) {
     $_SESSION["db_connection"] = mysqli_connect($db_host, $db_user, $db_password, $db_name);
 	 if (!$_SESSION["db_connection"]) {
 	 	exit("Database connection could not be established");
 	 }
 }

 function selectFromTable ($sqlStatement) {
 	if (!$_SESSION["db_connection"]) {
 		return false;
 	} else {
 		return mysqli_query($_SESSION["db_connection"], $sqlStatement);
 	}
 }

 function db_Statement ($sqlStatement) {
 	if (!$_SESSION["db_connection"]) {
 		return false;
 	} else {
 		if (mysqli_query($_SESSION["db_connection"], $sqlStatement)) {
 			return true;
 		}
 		return false;
 	}
 }

 function db_insertStatement ($sqlStatement) {
 	if (!$_SESSION["db_connection"]) {
 		return 0;
 	} else {
 		if (mysqli_query($_SESSION["db_connection"], $sqlStatement)) {
 			return mysqli_insert_id($_SESSION["db_connection"]);
 		}
 		return 0;
 	}
 }

 function getNextId ($table, $columnName) {
 	$sqlStatement = "SELECT MAX(" . $columnName . ") FROM " . $table;
 	$result = selectFromTable($sqlStatement);
 	if ($result) {
 		if ($zeile = mysqli_fetch_row($result)) {
 			return $zeile[0] + 1;
 		}
 	}
 	return 1;
 }

 function getNextSeqId ($table) {
 	return getNextId($table, "SEQID");
 }

 function getSingleRowByStatement ($statement) {
 	$result = selectFromTable($statement);
 	if ($result) {
 		if ($zeile = mysqli_fetch_row($result)) {
 			return $zeile;
 		}
 	}
 	return null;
 }

 function getSingleValueByStatement ($statement) {
 	$result = selectFromTable($statement);
 	if ($result) {
 		if ($zeile = mysqli_fetch_row($result)) {
 			return $zeile[0];
 		}
 	}
 	return null;
 }

 function checkUniqueExist($table, $field, $value) {
 	$sqlStatement = "SELECT * FROM $table WHERE $field LIKE '$value'";
 	return checkUniqueExistStatement($sqlStatement);
 }

 function checkUniqueExistStatement ($sqlStatement) {
 	return (getSingleValueByStatement($sqlStatement) != null);
 }

 function getUniqueValue($table, $field, $length) {
     $value = generatePassword($length);
     while (checkUniqueExist($table, $field, $value)) {
         $value = generatePassword($length);
     }
     return $value;
 }

 function preventInject($value) {
    // TODO are there more functions to prevent injection?
    return mysqli_real_escape_string ($_SESSION["db_connection"], $value);
 }

?>