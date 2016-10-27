<<<<<<< HEAD
<?php
include 'db_dataset.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();

			
if (isset($_GET["node_name"]) && isset($_GET["resource_name"]) && isset($_GET["value"]) && isset($_GET["unit"])&& isset($_GET["timestamp"]) && isset($_GET["relative_position"]) && isset($_GET["pos_x"]) && isset($_GET["pos_y"]) && isset($_GET["pos_z"]))
{	

		$sql = "insert into measurements (node_name,resource_name,value,unit,timestamp,relative_position,pos_x,pos_y,pos_z) values (\""
		.mysqli_real_escape_string($conn,$_GET["node_name"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["resource_name"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["value"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["unit"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["timestamp"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["relative_position"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["pos_x"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["pos_y"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["pos_z"])."\""
		.")";
		
		if (mysqli_query($conn, $sql))
		{
			$last_id = mysqli_insert_id($conn);		
			$Json->addContent(new textJson("Success"));
			$Json->addContent(new propertyJson("ID",$last_id));
		}
		else
		{
			$Json->addContent(new textJson("Fail"));
			if (isset($_GET["debug"]))
			{
				echo $sql;
			}
		}
}
else
{
	$Json->addContent(new textJson("Please provide node_name,resource_name,value,unit,timestamp,relative_position,pos_x,pos_y and pos_z in arguments."));
}

json_send($Json);
?>
=======
<?php
include 'db_dataset.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();

			
if (isset($_GET["node_name"]) && isset($_GET["resource_name"]) && isset($_GET["value"]) && isset($_GET["unit"])&& isset($_GET["timestamp"]) && isset($_GET["relative_position"]) && isset($_GET["pos_x"]) && isset($_GET["pos_y"]) && isset($_GET["pos_z"]))
{	

		$sql = "insert into measurements (node_name,resource_name,value,unit,timestamp,relative_position,pos_x,pos_y,pos_z) values (\""
		.mysqli_real_escape_string($conn,$_GET["node_name"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["resource_name"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["value"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["unit"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["timestamp"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["relative_position"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["pos_x"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["pos_y"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["pos_z"])."\""
		.")";
		
		if (mysqli_query($conn, $sql))
		{
			$last_id = mysqli_insert_id($conn);		
			$Json->addContent(new textJson("Success"));
			$Json->addContent(new propertyJson("ID",$last_id));
		}
		else
		{
			$Json->addContent(new textJson("Fail"));
			if (isset($_GET["debug"]))
			{
				echo $sql;
			}
		}
}
else
{
	$Json->addContent(new textJson("Please provide node_name,resource_name,value,unit,timestamp,relative_position,pos_x,pos_y and pos_z in arguments."));
}

json_send($Json);
?>
>>>>>>> 27d9b6c62a9e744b3ec8b82881bc1984279cfbee
