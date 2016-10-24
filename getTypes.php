<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
$sql = "SELECT * from resources_types";

if (isset($_GET['id']))
{
	$sql.=" where resources_types.id=".mysqli_real_escape_string($conn,$_GET["id"]);
}

if (isset($_GET['name']))
{
	$sql.=" where resources_types.name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
}

$allTypesA = mysqli_query($conn, $sql);
	if (isset($allTypesA))
		if (mysqli_num_rows($allTypesA) > 0)
			while($row = mysqli_fetch_assoc($allTypesA)) {
				$jsonreply = new StdClass();
				$jsonreply->type_id=$row['id'];
				$jsonreply->name=$row['name'];
				$allTypes[] = $jsonreply;
		}
if (!empty($allTypes))
{
	$Json->addContent(new arrayJson("Types",$allTypes));
}

json_send($Json);
mysqli_close($conn);
?>