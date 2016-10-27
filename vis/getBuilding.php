<?php
include '../db_model.php';
include '../json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();

$sql="select * from building";

$allWalls = mysqli_query($conn, $sql);
if (isset($_GET['scale']))
{
	$scale=mysqli_real_escape_string($conn,$_GET["scale"]);
}
else
{
	$scale=1;
}

if (mysqli_num_rows($allWalls) > 0) {
	while($row = mysqli_fetch_assoc($allWalls)) {
		$jsonreply = new StdClass();		
		$jsonreply->positionx=$row['position_x']*$scale;
		$jsonreply->positiony=$row['position_y']*$scale;
		$jsonreply->positionz=$row['position_z']*$scale;
		
		$jsonreply->scalex=$row['scale_x']*$scale;
		$jsonreply->scaley=$row['scale_y']*$scale;
		$jsonreply->scalez=$row['scale_z']*$scale;
		
		$jsonreply->type=$row['type'];
		
		
		$allWallsArray[] = $jsonreply;
	}
	
	if (!empty($allWallsArray))
	{
		$Json->addContent(new arrayJson("walls",$allWallsArray));
	}
	
}
json_send($Json);


?>