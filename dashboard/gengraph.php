<?php

if (PHP_SAPI != 'cli') {
	die('CLI only');
}

// Get current count
require(dirname(__FILE__).'/../db.php');
$sql = "SELECT COUNT(*) FROM `".TABLE_PREFIX."_responses`";
$rsc = mysql_query($sql);
list($count) = mysql_fetch_array($rsc);

// Set current count
$sql = "INSERT INTO `".TABLE_PREFIX."_history` VALUES(NOW(), ".$count.");";
$rsc = mysql_query($sql);

// Get all counts
$sql = "SELECT * FROM `".TABLE_PREFIX."_history` ORDER BY `date` ASC";
$rsc = mysql_query($sql);

$response_counts = array();
$response_dates = array();
while($row = mysql_fetch_object($rsc)) {
    $response_counts[] = $row->responses;
    $response_dates[] = date('M j H:i', strtotime($row->date));
}

 /* pChart library inclusions */ 
  include("pchart/class/pData.class.php"); 
  include("pchart/class/pDraw.class.php"); 
  include("pchart/class/pImage.class.php"); 

  /* Create and populate the pData object */

 // good luck beyond this point
  $MyData = new pData();

  $MyData->addPoints($response_counts, "Counts");
  $MyData->setAxisName(0, "Responses");
  $MyData->addPoints($response_dates, "Dates");
  $MyData->setSerieDescription("Dates", "Date");
  $MyData->setAbscissa("Dates");

  /* Create the pChart object */ 
  $myPicture = new pImage(1500,1000,$MyData);
  $myPicture->setFontProperties(array("FontName"=>dirname(__FILE__)."/pchart/fonts/verdana.ttf","FontSize"=>12));
  $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
  $RectangleSettings = array("R"=>180,"G"=>180,"B"=>180,"Alpha"=>40,"Dash"=>TRUE,"DashR"=>240,"DashG"=>240,"DashB"=>240,"BorderR"=>100, "BorderG"=>100,"BorderB"=>100); 
  $myPicture->drawFilledRectangle(1,1,1499,75,$RectangleSettings);
  $myPicture->drawText(20, 30,"Daily Trend",array("FontSize"=>12,"FontWeight" => "Bold"));
  $myPicture->drawText(20, 60,SURVEY_NAME,array("FontSize"=>20,"FontWeight" => "Bold"));
  $myPicture->setShadow(FALSE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
  $myPicture->drawFromPNG(1430,10,dirname(__FILE__).'/cat.png');
  $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
  $myPicture->drawText(120, 110,date("F j, Y, g:i a") ,array("FontSize"=>12,"FontWeight" => "Bold"));
  $myPicture->drawText(120, 130,"(c) Felix Imperial - www.felixonline.co.uk",array("FontSize"=>12,"FontWeight" => "Bold"));

  /* Draw the scale and the 1st chart */ 
  $myPicture->setGraphArea(100,100,1450,900);
  $myPicture->drawScale(array("DrawSubTicks"=>TRUE, "LabelRotation"=>46));
  $myPicture->drawLineChart(); 

  /* Render the picture (choose the best way) */ 
  $myPicture->render(dirname(__FILE__)."/graph.png");
  
  echo dirname(__FILE__)."/graph.png generated\n";
