<?php
include './db_dataset.php';
include './json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
$sql = "SELECT * from measurements ";
$wheres[]="1";

if (isset($_GET['resource_id']))
{
	$where="resource_name='".mysqli_real_escape_string($conn,$_GET["resource_id"])."'";
}


$sql.="where ".$where." order by id desc limit 10 ";

if ( isset($_GET['debug']))
{
	echo $sql;
}
	
$allMeasurementsA = mysqli_query($conn, $sql);
if (isset($allMeasurementsA))
		if (mysqli_num_rows($allMeasurementsA) > 0)
			while($row = mysqli_fetch_assoc($allMeasurementsA)) {
				$jsonreply = new StdClass();
				$jsonreply->id=$row['id'];
				$jsonreply->node_name=$row['node_name'];
				$jsonreply->resource_name=$row['resource_name'];
				$jsonreply->value=$row['value'];
				$jsonreply->unit=$row['unit'];
				$jsonreply->pos_x=$row['pos_x'];
				$jsonreply->pos_y=$row['pos_y'];
				$jsonreply->pos_z=$row['pos_z'];
				$jsonreply->timestamp=$row['timestamp'];
				$jsonreply->time_of_collection=$row['time_of_collection'];
				$jsonreply->timestamp_unix=$row['timestamp_unix'];
				$jsonreply->time_of_collection_unix=$row['time_of_collection_unix'];
				$allMeasurements[] = $jsonreply;
			}
if (!empty($allMeasurements))
{
	$Json->addContent(new arrayJson("Measurements",$allMeasurements));
	//$Json->addContent(new jsonJson($allMeasurements));
}

		

json_send($Json);
mysqli_close($conn);
?>