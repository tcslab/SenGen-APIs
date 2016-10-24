<?php

header('Access-Control-Allow-Origin: *');
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pData.class.php");
include("class/pSurface.class.php");


$myData = new pData();


$myData->addPoints(explode(",",$_GET["data"]),"Data");
$myData->setAxisName(0,$_GET["unit"]);
$myData->addPoints(explode(",",$_GET["timePoints"]),"Labels");
$myData->setSerieDescription("Labels","Time Points");
$myData->setAbscissa("Labels");
$serieSettings = array(array("R"=>55,"G"=>91,"B"=>127));
$myData->setPalette("Data",$serieSettings);
$myPicture = new pImage(512,512,$myData);
$myPicture->setGraphArea(58,58,460,460);
$myPicture->drawFilledRectangle(58,58,460,460,array("R"=>255,"G"=>255,"B"=>0,"Surrounding"=>-200,"Alpha"=>10));
$myPicture->setFontProperties(array("FontName"=>"fonts/Bedizen.ttf","FontSize"=>9));
$myPicture->drawScale(array("DrawSubTicks"=>TRUE));
$myPicture->drawStepChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));

$myPicture->Stroke();
?>