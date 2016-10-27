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

if (isset($_GET["type_id"]) && 
	isset($_GET["position_x"]) &&
	isset($_GET["position_y"]) &&
	isset($_GET["position_z"]) &&
	isset($_GET["name"])
)
{
	$sql = "insert into virtual (type_id,position_x, position_y,position_z,name) values 
		(
		".mysqli_real_escape_string($conn,$_GET["type_id"]).",
		".(mysqli_real_escape_string($conn,$_GET["position_x"])/$scale).",
		".(mysqli_real_escape_string($conn,$_GET["position_y"])/$scale).",
		".(mysqli_real_escape_string($conn,$_GET["position_z"])/$scale).",
		\"".mysqli_real_escape_string($conn,$_GET["name"])."\"
		)";
		//echo $sql;
	if (mysqli_query($conn, $sql))
	{
		$last_id = mysqli_insert_id($conn);		
		$Json->addContent(new textJson("Success inserting new virtual resource"));
		$Json->addContent(new propertyJson("ID",$last_id));
	}
	else
	{
		$Json->addContent(new textJson("Insert failed"));
		if (isset($_GET["debug"]))
		{
			echo $sql;
		}
		
	}
}
else
if (isset($_GET["id"]))
{
	if (isset($_GET["action"]))
	{
		if ($_GET["action"]=="delete")
		{
		$sql = "delete from virtual where id= ".mysqli_real_escape_string($conn,$_GET["id"]);
		if (mysqli_query($conn, $sql))
		{
			$Json->addContent(new textJson("Success deleting virtual resource"));
		}
		else
		{
			$Json->addContent(new textJson("Delete failed"));
			if (isset($_GET["debug"]))
			{
				echo $sql;
			}
			
		}
		}
		else
		{
			$Json->addContent(new textJson("Error: Action parameter not set"));
		}
	}
	else
	{
	
		$sql = "update virtual set ";
		if (isset($_GET["name"]) )
		{
			$updateSets[]="name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
		}
		if (isset($_GET["position_x"]) )
		{
			$updateSets[]="position_x=\"".(mysqli_real_escape_string($conn,$_GET["position_x"])/$scale)."\"";
		}
		if (isset($_GET["position_y"]) )
		{
			$updateSets[]="position_y=\"".(mysqli_real_escape_string($conn,$_GET["position_y"])/$scale)."\"";
		}
		if (isset($_GET["position_z"]) )
		{
			$updateSets[]="position_z=\"".(mysqli_real_escape_string($conn,$_GET["position_z"])/$scale)."\"";
		}
		
		if (isset($_GET["type_id"]) )
		{
			$updateSets[]="type_id=\"".mysqli_real_escape_string($conn,$_GET["type_id"])."\"";
		}
		
		$sql.=implode(",",$updateSets);
		$sql.=" where id=".mysqli_real_escape_string($conn,$_GET["id"]);
		if (mysqli_query($conn, $sql))
		{
			$Json->addContent(new textJson("Success updating virtual resource"));
		}
		else
		{
			$Json->addContent(new textJson("Update failed"));
			if (isset($_GET["debug"]))
			{
				echo $sql;
			}
			
		}
	}
}
else
{
	$Json->addContent(new textJson("Error: Parameters not set"));
}
json_send($Json);


?>