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

$sql="select * from virtual ";

$wheres[]="1";
	
if (isset($_GET["id"]))
{
	if (substr_count($_GET["id"],",")==0)
	{
		$wheres[]=" virtual.id=".mysqli_real_escape_string($conn,$_GET["id"]);
	}
	else
	{
		$wheres[]=" virtual.id in (".mysqli_real_escape_string($conn,$_GET["id"]).")";		
	}
}

if (count($wheres)>0)
{
	$sql.="where ";
	$sql.=implode(" and ",$wheres);
}

$allResourcePositions = mysqli_query($conn, $sql); 
if (isset($_GET["debug"]))
{
	echo $sql;
}
if (mysqli_num_rows($allResourcePositions) > 0) {
	while($row = mysqli_fetch_assoc($allResourcePositions)) {
		$jsonreply = new StdClass();
		$jsonreply->id=$row['id'];
		$jsonreply->positionx=$row['position_x']*$scale;
		$jsonreply->positiony=$row['position_y']*$scale;
		$jsonreply->positionz=$row['position_z']*$scale;		
		$jsonreply->name=$row['name'];
		$jsonreply->type_id=$row['type_id'];
				
		$allResourcePositionsArray[] = $jsonreply;
	}
	
	if (!empty($allResourcePositionsArray))
	{
		$Json->addContent(new arrayJson("resource_positions",$allResourcePositionsArray));
	}
	
}
json_send($Json);


?>