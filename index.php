<?php
	/* 
	 * Written by Peter J. Ford
	 * 2015-05-12
	 */
	require_once('config/db.php');
	$pagename = "PJ's Vehicle Logs";
?>
<html>
<head>
<title><?php echo $pagename; ?></title>
<link href="config/pjs.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<h1><?php echo $pagename; ?></h1>

<h3><a href="view.php?viewpage=garage">Garage</a></h3>
<h3><a href="view.php?viewpage=drivers">Drivers</a></h3>
<h3><a href="view.php?viewpage=fuel">Fuel</a></h3>
<h3><a href="maint.php">Maintenance</a></h3>
<h3><a href="repair.php">Repair</a></h3>

<div class="push"></div>
</div>

<div class="footer"><a href="blank.html">Blank page</a></div>
</body></html>