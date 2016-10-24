<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password);
mysqli_set_charset($conn,"utf8");
if (!$conn)
{
		die("Connection failed: ".mysqli_connect_error());
}
$sql = "USE dataset";
mysqli_query($conn, $sql);?> 