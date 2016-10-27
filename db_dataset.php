<?php
$servername = "localhost";
$username = "root";
<<<<<<< HEAD
$password = "uTh6ap8eesei";
=======
$password = "";
>>>>>>> 27d9b6c62a9e744b3ec8b82881bc1984279cfbee
$conn = mysqli_connect($servername, $username, $password);
mysqli_set_charset($conn,"utf8");
if (!$conn)
{
		die("Connection failed: ".mysqli_connect_error());
}
$sql = "USE dataset";
mysqli_query($conn, $sql);?> 