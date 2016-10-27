<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["nodes_id"]))
{
	
	$sql = "update nodes set ";
	if (isset($_GET["pos_y"]) )
	{
		$updateSets[]="pos_y=\"".mysqli_real_escape_string($conn,$_GET["pos_y"])."\"";
	}
	if (isset($_GET["name"]) )
	{
		$updateSets[]="name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
	}
	if (isset($_POST["pos_x"]) )
	{
		$updateSets[]="pos_x=\"".mysqli_real_escape_string($conn,$_POST["pos_x"])."\"";
	}
	
		if (isset($_GET["pos_z"]) )
	{
		$updateSets[]="pos_z=\"".mysqli_real_escape_string($conn,$_GET["pos_z"])."\"";
	}


	
		
	$sql.=implode(",",$updateSets);
	$sql.=" where id=".mysqli_real_escape_string($conn,$_GET["nodes_id"]);
	
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
	$Json->addContent(new textJson("Please provide the nodes_id of the node to be updated in the arguments. Available update arguments are name,pos_x,pos_y and pos_z"));
}

json_send($Json);
?>