<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
$sql = "SELECT * from nodes";

if (isset($_GET['id']))
{
	$sql.=" where nodes.id=".mysqli_real_escape_string($conn,$_GET["id"]);
}

if (isset($_GET['name']))
{
	$sql.=" where nodes.name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
}

$allNodesA = mysqli_query($conn, $sql);
if (isset($allNodesA))
		if (mysqli_num_rows($allNodesA) > 0)
			while($row = mysqli_fetch_assoc($allNodesA)) {
				$jsonreply = new StdClass();
				$jsonreply->node_id=$row['id'];
				$jsonreply->name=$row['name'];
				$jsonreply->pos_x=$row['pos_x'];
				$jsonreply->pos_y=$row['pos_y'];
				$jsonreply->pos_z=$row['pos_z'];
				$allNodes[] = $jsonreply;
			}
if (!empty($allNodes))
{
	$Json->addContent(new arrayJson("Nodes",$allNodes));
}

json_send($Json);
mysqli_close($conn);
?>