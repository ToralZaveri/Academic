<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost:3308');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Toral123');
define('DB_NAME', 'class');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect("localhost:3308", "root", "Toral123", "class");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>