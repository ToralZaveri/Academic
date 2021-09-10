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
if(isset($_POST['search'])) {
	
	$searchq = $_POST['query'];

	$searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
	$studentId = $_SESSION["id"];
	//echo $searchq;

	$query = mysqli_query($con, "SELECT * FROM class WHERE ClassNumber not in 
		(select CourseID from schedule where studentId = '$studentId') and 
		(ClassNumber LIKE '%$searchq%' OR ClassName LIKE '%$searchq%')") 
			or die("could not search");
			$count = mysqli_num_rows($query);
	
		}
	
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
     <center><p><img src="header.jpg"><p align="right"><a href="logout.php" class="btn btn-danger">Sign Out</a></p>
    <title>Class Search</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  </head>
  <style>
   
    .search {
      margin: 1 auto;
      width: 1000px;
      text-align: center;
      color: black;
      background-color: #AED68A;
    }

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
    	body{ font: 14px sans-serif; text-align: center; }
  </style>
  <body>
  	<div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["fullname"]); ?></b>. Summer 2020 ClassSearch.</h1>
        	
        
    
    <div class="search">
      <form action="class.php" method="POST">
        <input type="text" name="query" placeholder="Search by class name or number..."/>
        <input type="submit" name="search" value="Search" />
      <br><br>
      
      	<center>
      		<?php
           		
				if($count == 0) {
					$output = 'There was no search result';
				} else { 
			?>
				<table border="2">
		      		<tr><th>Select</th>
		      			<th>ClassNumber</th>
		      			<th>ClassName</th>
		      			<th>ClassTime</th>
		      			<th>Days</th>
		      			<th>ProfessorName</th>
		      		</tr> 
				<?php	
				while($row = mysqli_fetch_array($query)) {
						$result = "<tr><td><input type='checkbox' name='classCheck[]' value='".$row['ClassNumber']."'></td><td>"
						.$row ['ClassNumber']."</td><td>".$row ['ClassName']."</td><td>".$row ['ClassTime']."</td><td>"
						.$row ['Days']."</td><td>".$row ['ProfessorName']."</td></tr>";
						echo $result;			
				 }
				 ?>
				
				</table><br><br>
				<!--<a href="schedule.php" class="btn btn-danger">Submit</a>-->
				<input type="submit" name="submit" value="Submit" class="btn btn-danger" />
				</form>
			<?php  
			  }

			if(isset($_POST["submit"])) {	
				$query = "INSERT INTO schedule (StudentID, CourseID) Values(?, ?)"; 

				if($stmt = mysqli_prepare($con, $query)){
					mysqli_stmt_bind_param($stmt, "ss", $param_StudentID, $param_CourseID);
		            // Set parameters
		            $param_StudentID = $_SESSION["id"];
		            
					if(!empty($_POST['classCheck'])){
						// Loop to store and display values of individual checked checkbox.
						foreach($_POST['classCheck'] as $selected){
							$param_CourseID = $selected;
							//echo  "stedentId: ".$_SESSION["id"]." - CourseId:". $selected."</br>";
							// Attempt to execute the prepared statement
				            if(mysqli_stmt_execute($stmt)){
				                // Store result
				                mysqli_stmt_store_result($stmt);
				                            // Redirect user to schedule page
				                header("location: schedule.php");
				                	 
				            }
						}
					}
				}
 			}
	?>
			  
  			
      	 
    
    </div>
  </body>
</html>