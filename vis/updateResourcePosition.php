<?php
include '../db_model.php';
include '../json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["node_id"]) && isset($_GET["position_x"]) &&isset($_GET["position_y"]) &&isset($_GET["position_z"]))
{
if (isset($_GET['scale']))
{
	$scale=mysqli_real_escape_string($conn,$_GET["scale"]);
}
else
{
	$scale=1;
}

$sql="select * from physical_positions ";

$wheres[]="1";
	
if (isset($_GET["node_id"]))
{
		$wheres[]=" physical_positions.node_id=".mysqli_real_escape_string($conn,$_GET["node_id"]);
}

if (count($wheres)>0)
{
	$sql.="where ";
	$sql.=implode(" and ",$wheres);
}

$allResourcePositions = mysqli_query($conn, $sql); 

if (mysqli_num_rows($allResourcePositions) == 1) {
	$sql = "update physical_positions set position_x=".(mysqli_real_escape_string($conn,$_GET["position_x"])/$scale).", position_y=".(mysqli_real_escape_string($conn,$_GET["position_y"])/$scale).",position_z=".(mysqli_real_escape_string($conn,$_GET["position_z"])/$scale)." where node_id=".mysqli_real_escape_string($conn,$_GET["node_id"]);
	//echo $sql ;
	mysqli_query($conn, $sql);
		
	$Json->addContent(new textJson("Success updating resource position"));
}
else
	
	{
		$sql = "insert into physical_positions (node_id,position_x, position_y,position_z) values (".mysqli_real_escape_string($conn,$_GET["node_id"]).",".(mysqli_real_escape_string($conn,$_GET["position_x"])/$scale).",".(mysqli_real_escape_string($conn,$_GET["position_y"])/$scale).",".(mysqli_real_escape_string($conn,$_GET["position_z"])/$scale).")";
		//echo $sql;
		mysqli_query($conn, $sql);
		$Json->addContent(new textJson("Success inserting new resource position"));
		$Json->addContent(new propertyJson("ID",$last_id));
	}
	
}
else
{
	$Json->addContent(new textJson("Error: Parameters not set"));
}
json_send($Json);


?>