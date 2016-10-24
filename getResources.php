<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
$sql = "SELECT *,(select name from resources_types where resources_types.id=resources.type_id) as type_name,(select name from nodes where nodes.id=resources.nodes_id) as node_name  FROM `resources`";

if (isset($_GET['node_id']))
{
	$sql.=" where resources.nodes_id=".mysqli_real_escape_string($conn,$_GET["node_id"]);
}

$allResourcesA = mysqli_query($conn, $sql);
if (isset($allResourcesA))
		if (mysqli_num_rows($allResourcesA) > 0)
			while($row = mysqli_fetch_assoc($allResourcesA)) {
				$jsonreply = new StdClass();
				$jsonreply->resource_id=$row['id'];
				$jsonreply->name=$row['name'];
				$jsonreply->type_id=$row['type_id'];
				$jsonreply->nodes_id=$row['nodes_id'];
				$jsonreply->path=$row['path'];
				$jsonreply->last_seen=$row['last_seen'];
				$jsonreply->type_name=$row['type_name'];
				$jsonreply->node_name=$row['node_name'];
				$allResources[] = $jsonreply;
			}
if (!empty($allResources))
{
	$Json->addContent(new arrayJson("Resources",$allResources));
}

json_send($Json);
mysqli_close($conn);
?>