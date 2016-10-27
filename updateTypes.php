<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["types_id"]) && isset($_GET["name"]) )
{
	
	$sql = "update types set ";
	
	if (isset($_GET["name"]) )
	{
		$updateSets[]="name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
	}
		
		
	$sql.=implode(",",$updateSets);
	$sql.=" where id=".mysqli_real_escape_string($conn,$_GET["types_id"]);
	
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
	$Json->addContent(new textJson("Please provide the types_id of the node to be updated in the arguments. Available update argument is name"));
}

json_send($Json);
?>