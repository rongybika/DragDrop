<?php
require_once('connect.php');
//$res = $db->query('DELETE * FROM `dragdrop`');
//var_dump($_POST);
try {
$res = $db->query("INSERT INTO `dragdrop` (`ID`, `value`, `position`) VALUES(" . count($_POST['elements']) . ",'" . $_POST['value'] . "'," . count($_POST['elements']) . ")");
/*$stmt = $db->prepare("INSERT INTO `dragdrop` VALUES(':id',:value,:position)");
	$stmt->bindParam(':id', $id);
    $stmt->bindParam(':value', $value);
    $stmt->bindParam(':position', $position);*/
	} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    //echo $ex;
}
?>