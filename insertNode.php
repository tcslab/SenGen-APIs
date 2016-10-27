<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();

if (isset($_GET["name"]) && isset($_GET["pos_x"]) && isset($_GET["pos_y"]) && isset($_GET["pos_z"]))
{
	$sql = "insert into nodes (name,pos_x,pos_y,pos_z) values (\"".mysqli_real_escape_string($conn,$_GET["name"])."\",\"".mysqli_real_escape_string($conn,$_GET["pos_x"])."\",\"".mysqli_real_escape_string($conn,$_GET["pos_y"])."\",\"".mysqli_real_escape_string($conn,$_GET["pos_z"])."\"
	)";
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
	$Json->addContent(new textJson("Please provide name, pos_x, pos_y,pos_z in arguments"));
}

json_send($Json);
?>
