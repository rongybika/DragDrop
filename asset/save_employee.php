<?php
require_once('connect.php');
try {
    var_dump($_POST);
	/*$res = $db->query('DELETE FROM `daily` WHERE `department`=' . $_POST['department'] . " AND `date`='" . $_POST['date'] . "'");*/
    
	/*$sql = "DELETE FROM movies WHERE filmID =  :filmID";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':filmID', $_POST['filmID'], PDO::PARAM_INT);   
	$stmt->execute();*/

	/*$stmt = $db->prepare("INSERT INTO `daily` (`ID`, `department`, `employee_id`, `position`, `date`) VALUES(NULL," . $_POST['department'] . ", :employee_id, :position, '".$_POST['date']."')");*/

    /*$stmtInsert = $db->prepare("INSERT INTO `daily` (`ID`, `department`, `employee_id`, `position`, `date`) VALUES(NULL," . $_POST['department'] . ", :employee_id, :position, '".$_POST['date']."')");
    
    $stmtInsert->bindParam(':employee_id', $employee_id);
	$stmtInsert->bindParam(':position', $position);*/
    
    $stmtUpdate = $db->prepare("UPDATE `daily` SET `department`=" . $_POST['department'] . ",`position`=:position WHERE `employee_id`=:employee_id AND `date`='" . $_POST['date'] . "'");
    
	$stmtUpdate->bindParam(':employee_id', $employee_id);
	$stmtUpdate->bindParam(':position', $position);
	/*echo 'department=' . $_POST['department'];*/
	$i = 1;

	foreach ($_POST['data'] as $value) {
		$employee_id = intval(str_replace('ui-id-','',$value));
		$position = $i;
        echo $employee_id;
        echo $position;
		$stmtUpdate->execute();
		$i ++;
	}

	
	/*var_dump($_POST);*/
	
	} catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    echo $ex;
}
?>
