<?php
require_once('connect.php');

try {
$res = $db->query("INSERT INTO `employee` (`ID`, `firstname`, `surname`) VALUES(NULL,'" . $_POST['new_firstname'] . "','" . $_POST['new_surname'] . "')");

	} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    echo $ex;
}
?>
