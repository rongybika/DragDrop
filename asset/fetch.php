<?php  
 //fetch.php  
 //$connect = mysqli_connect("localhost", "root", "", "testing");  
require_once('connect.php');

 if(isset($_POST["employee_id"]))  
 {  
      $query = "SELECT * FROM `employee` WHERE `ID` = '".$_POST["employee_id"]."'";  
      $result = $db->query($query);
      $details = $result->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($details[0]);
 }  
 ?>
