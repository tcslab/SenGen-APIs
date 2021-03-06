<?php
include 'db_dataset.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();

			
if (isset($_GET["node_name"]) && isset($_GET["resource_name"]) && isset($_GET["value"]) && isset($_GET["unit"])&& isset($_GET["timestamp"]) && isset($_GET["relative_position"]))
{	

		$sql = "insert into measurements (node_name,resource_name,value,unit,timestamp,relative_position) values (\""
		.mysqli_real_escape_string($conn,$_GET["node_name"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["resource_name"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["value"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["unit"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["timestamp"])."\",\""
		.mysqli_real_escape_string($conn,$_GET["relative_position"])."\")";

		
		
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
			else
			{
				echo $sql;
			}
		}
}
else
{
	$Json->addContent(new textJson("Please provide node_name,resource_name,value,unit,timestamp,relative_position in arguments."));
}

json_send($Json);
?>