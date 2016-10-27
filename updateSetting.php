<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["name"]) && isset($_GET["value"]) )
{
	
	$sql = "update settings set ";
	
	
	if (isset($_GET["value"]) )
	{
		$updateSets[]="value=\"".mysqli_real_escape_string($conn,$_GET["value"])."\"";
	}
		
		
	$sql.=implode(",",$updateSets);
	$sql.=" where name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
	
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
	$Json->addContent(new textJson("Please provide the name and (new) value of the setting to be updated in the arguments."));
}

json_send($Json);
?>