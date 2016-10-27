<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["resources_id"]))
{
	
	$sql = "update resources set ";
	if (isset($_GET["type_id"]) )
	{
		$updateSets[]="type_id=\"".mysqli_real_escape_string($conn,$_GET["type_id"])."\"";
	}
	if (isset($_GET["name"]) )
	{
		$updateSets[]="name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
	}
	if (isset($_POST["nodes_id"]) )
	{
		$updateSets[]="nodes_id=\"".mysqli_real_escape_string($conn,$_POST["nodes_id"])."\"";
	}
	
		if (isset($_GET["path"]) )
	{
		$updateSets[]="path=\"".mysqli_real_escape_string($conn,$_GET["path"])."\"";
	}


	
		
	$sql.=implode(",",$updateSets);
	$sql.=" where id=".mysqli_real_escape_string($conn,$_GET["resources_id"]);
	
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
	$Json->addContent(new textJson("Please provide the resources_id of the resource to be updated in the arguments. Available update arguments are name,type_id,nodes_id and path"));
}

json_send($Json);
?>