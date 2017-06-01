<?php
require_once('connect.php');

$i = 1;

var_dump($_POST);
try {
$stmt = $db->prepare("UPDATE `dragdrop` SET `position`=:position WHERE `ID`=:id");
	$stmt->bindParam(':id', $id);
    //$stmt->bindParam(':value', $value);
    $stmt->bindParam(':position', $position);

foreach ($_POST['ui-id'] as $value) {
    echo 'index= ' . $i . ' value= ' . $value;
    $id = $value;
    $position = $i;
    $stmt->execute();
    $i++;
}
    } catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    //echo $ex;
}
?>
