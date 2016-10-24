<?php
include '../db_model.php';
include '../json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();

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
	if (substr_count($_GET["node_id"],",")==0)
	{
		$wheres[]=" physical_positions.node_id=".mysqli_real_escape_string($conn,$_GET["node_id"]);
	}
	else
	{
		$wheres[]=" physical_positions.node_id in (".mysqli_real_escape_string($conn,$_GET["node_id"]).")";
	}
}

if (count($wheres)>0)
{
	$sql.="where ";
	$sql.=implode(" and ",$wheres);
}

$allResourcePositions = mysqli_query($conn, $sql); 
//echo $sql;
if (mysqli_num_rows($allResourcePositions) > 0) {
	while($row = mysqli_fetch_assoc($allResourcePositions)) {
		$jsonreply = new StdClass();
		$jsonreply->resource_id=$row['id'];
		$jsonreply->positionx=$row['position_x']*$scale;
		$jsonreply->positiony=$row['position_y']*$scale;
		$jsonreply->positionz=$row['position_z']*$scale;
				
		$allResourcePositionsArray[] = $jsonreply;
	}
	
	if (!empty($allResourcePositionsArray))
	{
		$Json->addContent(new arrayJson("resource_positions",$allResourcePositionsArray));
	}
	
}
json_send($Json);


?>