<?php  
require_once('connect.php');

 if(isset($_POST["employee_id"]))  
 {  
      $output = '';  
      /*$connect = mysqli_connect("localhost", "root", "", "testing");  */
      $query = "SELECT * FROM `employee` WHERE `ID` = '".$_POST["employee_id"]."'";  
      //$result = mysqli_query($connect, $query);  
     $result = $db->query($query);
     $details = $result->fetchAll();
     if (!empty($details[0]['thumb_image'])) {
         $sThumbImage =  $details[0]['thumb_image'];
     } else {
         $sThumbImage = 'images/default';
     }
      $output .= '  
      <div class="table-responsive">  
      <div class="employee-thumb-view-container"><img src="' . $sThumbImage . '" class="employee-thumb-view"></div>
           <table class="table table-bordered">';  
      foreach($details as $row)  
      {  
           $output .= '  
                <tr>  
                     <td class="info" width="30%"><label>Firstname</label></td> 
                </tr>
                <tr>
                     <td class="info-e" width="30%">'.$row["firstname"].'</td>  
                </tr>  
                <tr>  
                     <td class="info" width="30%"><label>Surname</label></td> 
                </tr>
                <tr>
                     <td class="info-e" width="30%">'.$row["surname"].'</td>  
                </tr>  
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>
