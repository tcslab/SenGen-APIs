<<<<<<< HEAD
<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["name"]) && isset($_GET["status"]) )
{
	
	$sql = "update nodes set ";
		
	$sql.="Actuator1_status=\"".mysqli_real_escape_string($conn,$_GET["status"])."\"";
	$sql.=" where name like \"%".mysqli_real_escape_string($conn,$_GET["name"])."%\"";
	
	echo $sql;
	
	if (mysqli_query($conn, $sql))
	{	
		$Json->addContent(new textJson("Success"));
		
	}
	else
	{
		$Json->addContent(new textJson("Fail"));

	}
}
else
{
	$Json->addContent(new textJson("Please provide the name of the sensor and its actuation status to be updated in the arguments."));
}

json_send($Json);
?>
=======
<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["name"]) && isset($_GET["status"]) )
{
	
	$sql = "update nodes set ";
		
	$sql.="Actuator1_status=\"".mysqli_real_escape_string($conn,$_GET["status"])."\"";
	$sql.=" where name like \"%".mysqli_real_escape_string($conn,$_GET["name"])."%\"";
	
	echo $sql;
	
	if (mysqli_query($conn, $sql))
	{	
		$Json->addContent(new textJson("Success"));
		
	}
	else
	{
		$Json->addContent(new textJson("Fail"));

	}
}
else
{
	$Json->addContent(new textJson("Please provide the name of the sensor and its actuation status to be updated in the arguments."));
}

json_send($Json);
?>
>>>>>>> 27d9b6c62a9e744b3ec8b82881bc1984279cfbee
