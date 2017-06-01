<!DOCTYPE html>
<html>

<head>
    <title>Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!--Compiled and minified jQuery-->
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

</head>

<body>
    <div class="page-title">
        <h1>Select a date<br>&amp;<br>Just Drag and Drop Employees between departments</h1>
        <h5>(Built with PHP, MySQL, Javascript, AJAX)</h5>
    </div>

    <div class="input-form">
        <!--Date select form-->
        <form action="index.php" method="post">
            <label for="datepicker">Please choose a date: </label>
            <input type="text" id="datepicker" name="datepicker" value="<?php if( !empty($_POST['datepicker']) )
{ echo $_POST['datepicker']; }?>" required/>
            <input type="submit" value="Submit">
        </form>

        <!--Add new department form-->
        <form>
            <label for="new-department">You can add new department. Just type the name: </label>
            <input type="text" id="new-department" name="new-department" required/>
            <input id="add-new-department" type="submit" value="Submit">
        </form>

        <form id="form-add-new-employee">
            <div>
                <h4>Add new employee</h4>
            </div>
            <label for="new-firstname">Firstname</label>
            <input type="text" id="new-firstname" name="new-firstname" required/>
            <label for="new-surname">Surname</label>
            <input type="text" id="new-surname" name="new-surname" required/>
            <input id="add-new-employee-button" type="submit" value="Submit">
        </form>
    </div>


    <?php
    require_once('asset/connect.php');
    
if( !empty($_POST['datepicker']) )
{
try{
    /*Retrieve data  with foreign key for the selected date*/
    $result = $db->query("SELECT * FROM `employee` INNER JOIN `daily` ON `employee`.`ID`=`daily`.`employee_id` WHERE `date`='" . $_POST['datepicker'] . "' ORDER BY `daily`.`position` ASC");
    $employees = $result->fetchAll();
    
    /*Retrieve employees not included in any department*/
    $result = $db->query("SELECT * FROM `employee` WHERE `employee`.`ID` NOT IN (SELECT `daily`.`employee_id` FROM `employee` INNER JOIN `daily` ON `employee`.`ID`=`daily`.`employee_id` WHERE `date`='" . $_POST['datepicker'] . "')");
    $employeesAll = $result->fetchAll();
    
    /*Retrieve all departments*/
    $result = $db->query("SELECT * FROM `department`");
    $departments = $result->fetchAll();
        
        } catch(PDOException $ex) {
    echo "An Error occured!"; //user friendly message
    echo $ex;
}
   
    ?>
        <section class="sort-table">

            <div id="container0">
                <span><h3>Employee (All)</h3></span>
                <div id="mysort0" class="sortable_list connectedSortable" department="0">

                    <?php
    /*If exist employee not included in any department we will insert into `daily` table and we will display in All box*/
    if (count($employeesAll) != 0) {

        $stmtInsert = $db->prepare("INSERT INTO `daily` (`ID`, `department`, `employee_id`, `position`, `date`) VALUES(NULL,0, :employee_id, :position, '".$_POST['datepicker']."')");
    
        $stmtInsert->bindParam(':employee_id', $employee_id);
        $stmtInsert->bindParam(':position', $position);
        
        foreach( $employeesAll as $row ) {
        /*Insert employee into `daily` table when that day was untouched before for organize*/
        $employee_id = $row['ID'];
		$position = 0;
		$stmtInsert->execute();
        
        /*Display in All box any employees not dropped in any box*/
        echo '<div id="ui-id-' . $row['ID'] . '" class="ui-state-default"><img src="' . $row['thumb_image'] . '" class="employee-thumb">' . $row['ID'] . ' ' .$row['firstname'];
        echo '<input type="button" name="view" value="View" id="' . $employee_id . '" class="btn btn-info btn-xs view-data" />';
        echo '<input type="button" name="edit" value="Edit" id="' . $employee_id . '" class="btn btn-info btn-xs edit-data" />';
        echo '</div>';
          
    }
    }
    /*Display employees droped into All box*/
        foreach( $employees as $row ) {
        if ($row['department'] == 0) {
        echo '<div id="ui-id-' . $row['employee_id'] . '" class="ui-state-default"><img src="' . $row['thumb_image'] . '" class="employee-thumb">' . $row['employee_id'] . ' ' .$row['firstname'];
        echo '<input type="button" name="view" value="View" id="' . $row["employee_id"] . '" class="btn btn-info btn-xs view-data" />';
        echo '<input type="button" name="edit" value="Edit" id="' . $row["employee_id"] . '" class="btn btn-info btn-xs edit-data" />';
        echo '</div>';
        }    
    }
         
    ?>
                </div>
            </div>

            <?php
    /*Retrieve all departments and display them*/
    foreach($departments as $department){
        echo '<div class="container">';
        echo '<span><h3>' . $department['dep_name'] . '</h3></span>';
        echo '<div id="mysort' . $department['ID'] . '" class="sortable_list connectedSortable" department="' . $department['ID'] . '">';
        
        /*Display any employees in its own department*/
        foreach( $employees as $row ) {
            if ($row['department'] == $department['ID']) {
                echo '<div id="ui-id-' . $row['employee_id'] . '" class="ui-state-default"><img src="' . $row['thumb_image'] . '" class="employee-thumb">' . $row['employee_id'] . ' ' .$row['firstname'];
                echo '<input type="button" name="view" value="View" id="' . $row["employee_id"] . '" class="btn btn-info btn-xs view-data" />';
                echo '<input type="button" name="edit" value="Edit" id="' . $row["employee_id"] . '" class="btn btn-info btn-xs edit-data" />';
                echo '</div>';
            }    
        }
        echo '</div>';
        echo '</div>';
    }
}
               $db=null;
               unset($_POST['datepicker']);
            ?>

        </section>

        <footer>
        </footer>

        <?php 
    /*View modal*/
    require_once('asset/data_modal.php');
    ?>
        <!--Modification modal-->
        <div id="add_data_Modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update employee info</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="insert_form">
                            <label>Enter Employee First Name</label>
                            <input type="text" name="firstname" id="firstName" class="form-control" />
                            <br />
                            <label>Enter Employee Surname</label>
                            <textarea name="surname" id="surname" class="form-control"></textarea>
                            <br />
                            <!--
                            <label>Select Gender</label>
                            <select name="gender" id="gender" class="form-control">  
                               <option value="Male">Male</option>  
                               <option value="Female">Female</option>  
                          </select>
                            <br />
                            <label>Enter Designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" />
                            <br />
                            <label>Enter Age</label>
                            <input type="text" name="age" id="age" class="form-control" />
                            <br />
                            -->
                            <input type="hidden" name="employee_id" id="employee_id" />
                            <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
