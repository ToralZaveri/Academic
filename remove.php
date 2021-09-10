<?php 
include "config.php";

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
$id = $_POST['id'];
//echo $_SESSION["id"];
if($id <> ''){
  // Check record exists
  $checkQuery = "SELECT * FROM schedule WHERE courseId='$id' and studentId =".$_SESSION["id"];
  $checkRecord = mysqli_query($con, $checkQuery) or die("could not search");
  $totalrows = mysqli_num_rows($checkRecord);
  
  if($totalrows > 0){
    // Delete record
    $query = "DELETE FROM schedule WHERE courseid='".$id."' and studentId =".$_SESSION["id"];
    mysqli_query($con,$query);
    echo 1;
    exit;
  }
}
exit;
?>