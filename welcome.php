<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <center><p><img src="header.jpg">
    
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

    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["fullname"]); ?></b>. Welcome to ClassSearch.</h1>
    </div>
    <p>
        <p align="right"><a href="logout.php" class="btn btn-danger">Sign Out</a></p><br><br>
        <a href="class.php" class="btn btn-danger">Class Search</a><br><br>
        <a href="schedule.php" class="btn btn-danger">My Class Schedule</a>
    </p>
</body>
</html>