<?php  
require_once('connect.php');

if($_POST["employee_id"] != '')  
      {  
    try {
    $res = $db->query("UPDATE `employee` SET `firstname`='" . $_POST['firstname'] . "',`surname`='" . $_POST['surname'] . "' WHERE `ID`=" . $_POST['employee_id']);
        } catch(PDOException $ex) {
        echo "An Error occured!"; //user friendly message
        echo $ex;
    }
}
?>
