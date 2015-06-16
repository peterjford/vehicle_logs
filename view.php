<?php
	/*
	 * Written by Peter J. Ford
	 * 2015-05-13
	 * 2015-05-20 - added getDriversVehicles
	 * 2015-05-26 - added addpage switch
	 * 2015-06-01 - added form stuff, will also be part of addpage 
	 * 2015-06-02 - added form stuff for fuel, removed addpage switch.
	 */

require_once('config/db.php');
require_once('drivers.php');
require_once('garage.php');
require_once('fuel.php');

//name="pjs_fuel_id" value="' . $pjs_fuel_id . '"><td><input type="submit" name="remove_fuel_purchase" value="X"></form>';
if (isset($_POST['add_driver'])) {
	$drivers = new Driver();
	$drivers->addDriver($_POST['driver_name']);
    $table = $drivers->getDrivers();
    $pagename = $drivers->getPagename();
}

if (isset($_POST['remove_driver'])) {
    $drivers = new Driver();
    $drivers->removeDriver($_POST['driver_id']);
    $table = $drivers->getDrivers();
    $pagename = $drivers->getPagename();
}

if (isset($_POST['add_fuel'])) {
	$fuel = new Fuel();
	$fuel->fuelPurchase($_POST);
	$table = $fuel->getFuelLog($_POST['fuel_garage_id']);
	$pagename = $fuel->getPagename();
}

if (isset($_POST['remove_fuel_purchase'])) {
	$fuel = new Fuel();
	$fuel->removePurchase($_POST['pjs_fuel_id']);
	$table = $fuel->getFuelLog($_POST['vehicle_id']);
	$pagename = $fuel->getPagename();
}

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

?>
<html>
<head>
<title><?php echo $pagename; ?></title>
<link href="config/pjs.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<h1><a href="index.php">PJ's Vehicle Logs</a></h1>
<h2><?php echo (isset($pagename) ? $pagename : 'illegal entry'); ?></h2>

<?php 
	echo (isset($table) ? $table : 'No Data Available');
        echo (isset($form) ? $form : '');
?>

<div class="push"></div>
</div>
<div class="footer"><a href="blank.html">Blank page</a></div>
</body></html>

