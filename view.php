<?php
	/*
	 * Written by Peter J. Ford
	 * 2015-05-13
	 * 2015-05-20 - added getDriversVehicles
	 * 2015-05-26 - added addpage switch
	 * 
	 */

require_once('config/db.php');
require_once('drivers.php');
require_once('garage.php');
require_once('fuel.php');

if (isset($_GET['driversgarage'])) {
	$garage = new Garage();
	$table = $garage->getDriversVehicles($_GET['driversgarage']);
	$pagename= $garage->getPagename();
}

if (isset($_REQUEST['viewpage'])) {
	switch ($_REQUEST['viewpage']) {
		case 'drivers':
			$drivers = new Driver();
			$table = $drivers->getDrivers();
			$pagename = $drivers->getPagename();
			break;
			
		case 'garage' :
			$garage = new Garage();
			$table = $garage->getVehicles();
			$pagename= $garage->getPagename();			
			break;
			
		case 'fuel' :
			$fuel = new Fuel();
			if (isset($_REQUEST['fuel_id'])){
				$table = $fuel->getFuelLog($_REQUEST['fuel_id']);
			}
			$pagename= $fuel->getPagename();
			break;
			
	}
}

if (isset($_REQUEST['addpage'])) {
	switch ($_REQUEST['addpage']) {
		case 'drivers' :
			$drivers = new Driver();
			$table = $drivers->getDrivers();
			$pagename = $drivers->getPagename();
			break;
				
		case 'garage' :
			$garage = new Garage();
			$table = $garage->getVehicles();
			$pagename= $garage->getPagename();
			break;
			
		case 'fuel' :
			$fuel = new Fuel();
			if (isset($_REQUEST['fuel_id'])){
				$table = $fuel->getFuelLog($_REQUEST['fuel_id']);
			}
			$pagename= $fuel->getPagename();
			break;
	}
}


?>
<html>
<head>
<title><?php echo $pagename; ?></title>
<link href="config/pjs.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<h1><a href="index.php">PJ's Vehicle Logs</a></h1>
<h2><?php echo $pagename; ?></h2>

<?php 
	echo (isset($table) ? $table : 'No Data Available');
?>

<div class="push"></div>
</div>
<div class="footer"><a href="blank.html">Blank page</a></div>
</body></html>