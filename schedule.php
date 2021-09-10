<?php
// Initialize the session
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
     exit;
}

$ser="localhost:3308";
$user="root";
$pass="Toral123";
$db="class";

$con=mysqli_connect($ser, $user, $pass, $db) or die("Connection Failed");

if(mysqli_select_db($con, "class")){
//echo "\n DB is selected successfully";
}
else {echo "\n DB is not selected successfully";}

$output = '';
$count = 0;
$studentID = $_SESSION["id"];

$query = mysqli_query($con, "SELECT c.* FROM schedule as s join class as c on s.CourseId = c.ClassNumber WHERE s.StudentId = '$studentID'") or die("could not search");
      $count = mysqli_num_rows($query);
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <center><p><img src="header.jpg"><p align="right"><a href="logout.php" class="btn btn-danger">Sign Out</a></p>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }

    .btn-danger {
      background-color: forestgreen;
      border: 1;
      color: black;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }

    table {
     border-collapse: collapse;
     width: 100%;
    }

    th, td {
     text-align: left;
     padding: 8px;
    }

    tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["fullname"]); ?></b>. Summer 2020 Class Schedule.</h1>
    </div>
    <p>
        <form action="schedule.php" method="POST">
      <br><br>
      
        <center>
          <?php
              
        if($count == 0) {
          echo "<div>Your schedule is currently empty. Please <a href='class.php'>add</a> some classes</div>";
        } else { 
      ?><a href='class.php'>Back to class search</a>
        <br><br>
        <table border="2">
              <tr><th></th>
                <th>ClassNumber</th>
                <th>ClassName</th>
                <th>ClassTime</th>
                <th>Days</th>
                <th>ProfessorName</th>
              </tr> 
        <?php 
        while($row = mysqli_fetch_array($query)) {
            $result = "<tr><td><span class='delete' id='del_".$row['ClassNumber']."'>Drop</a></td><td>".$row ['ClassNumber']."</td><td>".$row ['ClassName']."</td><td>".$row ['ClassTime']."</td><td>".$row ['Days']."</td><td>".$row ['ProfessorName']."</td></tr>";
            echo $result;     
         }

         ?>
        
        </table><br><br>
        <?php  
        }?>
        <!--<a href="schedule.php" class="btn btn-danger">Submit</a>-->
        </form>
        
</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

  // Delete 
   $('.delete').click(function(){
     var el = this;
     var id = this.id;
     var splitid = id.split("_");

     // Delete id
     var deleteid = splitid[1];
   
     // AJAX Request
     $.ajax({
       url: 'remove.php',
       type: 'POST',
       data: { id:deleteid },
       success: function(response){
          debugger;
         if(response == 1){
     // Remove row from HTML Table
     $(el).closest('tr').css('background','tomato');
     $(el).closest('tr').fadeOut(800,function(){
        $(this).remove();
     });
        }else{
     alert('Invalid ID.');
        }

      }
     });

   });

});
</script>
</html>