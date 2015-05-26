<?php
	/* 
	 * Written by Peter J. Ford
	 * 2015-05-12
	 * 2015-05-18 - changed to class
	 * 2015-05-20 - added getDriversVehicles
	 * 2015-05-22 - updated db connection
	 */

require_once('drivers.php');
require_once('config/db.php');

class Garage {
	
	private $pagename = "PJ's Garage";
	private $header_row = '<tr><th>Year</th><th>Make</th><th>Model</th><th>Trim</th><th>License Plate</th><th>VIN</th><th>Nickname</th><th>Primary Driver</th></tr>';
	private $garage_columns = array('veh_year',	'veh_make', 'veh_model', 'veh_trim', 'veh_lic', 'veh_vin', 'veh_nickname');
			
	public function __construct() {

	}
	
	public function getVehicles($query = '') {
		$driver = new Driver();
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		if (empty($query)) {
			$query = "select * from pjs_garage";
		}
		$result = $mysqli->query($query);
		
		$table = '<table>';
		$table .= $this->header_row;
		while ($row = $result->fetch_assoc()) {
			$table .= '<tr>';
			foreach ($this->garage_columns as $var) {
				$table .= '<td';
				if ($var == 'veh_lic') {
					$table .= ' align="center" ';
				}
				$table .= '>' . $row[$var] . '</td>';
			}
			$table .= '<td>' . $driver->getDriver($row['veh_primary_driver_id']) . '</td><td><a href="view.php?viewpage=fuel&fuel_id=' . $row['pjs_garage_id'] . '"> Fuel </a></td>';
			$table .= '</tr>';
		}
		$table .= '</table>';
		return $table;
	}
	
	public function getDriversVehicles($drivers_id) {
		$query = "select * from pjs_garage where veh_primary_driver_id = $drivers_id";
		return $this->getVehicles($query);
	}
	
	public function getVehicle($vehicle_id) {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "select * from pjs_garage where pjs_garage_id = '$vehicle_id'";
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();
		return $row['veh_nickname'];
	}
	
	public function getPagename() {
		return $this->pagename;
	}

}
