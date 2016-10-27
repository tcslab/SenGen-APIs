<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
$sql = "SELECT * from settings";

if (isset($_GET['name']))
{
	$sql.=" where name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
}

$allResourcesA = mysqli_query($conn, $sql);
if (isset($allResourcesA))
		if (mysqli_num_rows($allResourcesA) > 0)
			while($row = mysqli_fetch_assoc($allResourcesA)) {
				$jsonreply = new StdClass();
				$jsonreply->setting_id=$row['id'];
				$jsonreply->name=$row['name'];
				$jsonreply->value=$row['value'];

				$allResources[] = $jsonreply;
			}
if (!empty($allResources))
{
	$Json->addContent(new arrayJson("Settings",$allResources));
}

		

json_send($Json);
mysqli_close($conn);
?>