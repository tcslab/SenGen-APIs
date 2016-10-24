<?php
include 'db_resource_directory.php';
include 'json.php';

$sql="insert into logging (ip, url,operation) values (\"".$_SERVER['REMOTE_ADDR']."\",\"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\",\"".basename(__FILE__, '.php')."\")";
mysqli_query($conn, $sql);

$Json = new json();
if (isset($_GET["type"]) && isset($_GET["id"]))
{	
	$possible_types = array("resources", "nodes", "resources_types");
	if (in_array($_GET["type"],$possible_types))
	{
		$sql = "delete from ".mysqli_real_escape_string($conn,$_GET["type"])." where id=".mysqli_real_escape_string($conn,$_GET["id"]);
		if (isset($_GET["debug"]))
		{
			echo $sql;
		}
		if (mysqli_query($conn, $sql))
		{
			$Json->addContent(new textJson("Success"));
		}
		else
		{
			$Json->addContent(new textJson("Fail"));
		}
	}
}
else
{
	if (isset($_GET["type"]) && isset($_GET["name"]))
	{
		if (mysqli_real_escape_string($conn,$_GET["type"])=="nodes")
		{
			$sql = "delete from ".mysqli_real_escape_string($conn,$_GET["type"])." where name=\"".mysqli_real_escape_string($conn,$_GET["name"])."\"";
			

			if (isset($_GET["debug"]))
			{
				echo $sql;
			}
			if (mysqli_query($conn, $sql))
			{
				$send_email="no";
				$Json->addContent(new textJson("Success"));
				$sql_setting = "select value from settings where name='notifications'";
				$setting = mysqli_query($conn, $sql_setting); 
				if (mysqli_num_rows($setting) > 0) {
					while($row = mysqli_fetch_assoc($setting)) {
						if ($row["value"]=="yes")
						{
							$send_email="yes";
						}
						else
						{
							$send_email="no";
						}	
					}
				}
				if ($send_email=="yes")
				{
					$subject = "SENGEN Node deleted";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/plain; charset=iso-8859-1";
					$headers[] = "From: marios.karagiannis@unige.ch";
					$headers[] = "Reply-To: marios.karagiannis@unige.ch";
					$headers[] = "X-Mailer: PHP/".phpversion();

					$to = "Stephane.Kundig@unige.ch";
					
					$message = "Node with name '".$_GET["name"]."' has been deleted!";
					$header = implode("\r\n", $headers);
					
					mail($to, $subject, $message, $header);
				}
			
			}
			else
			{
				$Json->addContent(new textJson("Fail"));
			}
		}
		else
		{
			$Json->addContent(new textJson("Delete by name only allowed on nodes"));
		}
	}
	else
	{
		$Json->addContent(new textJson("Please provide type and id arguments"));
		$Json->addContent(new textJson("Possible values for type: resources, nodes, resources_types"));
	}
}

json_send($Json);
	
?>