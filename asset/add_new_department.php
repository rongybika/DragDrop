<?php
require_once('connect.php');

try {
$res = $db->query("INSERT INTO `department` (`ID`, `dep_name`) VALUES(NULL,'" . $_POST['new_department'] . "')");

	} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    echo $ex;
}
?>
