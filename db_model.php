<?php
$servername = "localhost";
$username = "root";
$password = "uTh6ap8eesei";
=======
$password = "";

$conn = mysqli_connect($servername, $username, $password);
mysqli_set_charset($conn,"utf8");
if (!$conn)
{
		die("Connection failed: ".mysqli_connect_error());
}
$sql = "USE model";
mysqli_query($conn, $sql);?> 