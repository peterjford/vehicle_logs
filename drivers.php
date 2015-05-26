<?php
	/*
	 * Written by Peter J. Ford
 	 * 2015-05-12
 	 * 2015-05-18 - changed to class 
 	 * 2015-05-20 - added link to drivers vehicles
	 */

require_once('config/db.php');
	
class Driver {
	
	private $pagename = "PJ's Drivers";
	
	public function __construct() {
	}

	public function getDrivers() {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "select * from pjs_drivers";
		$result = $mysqli->query($query);
		
		$table = '<table>';
		while ($row = $result->fetch_assoc()) {
			$table .= '<tr><td><a href="view.php?driversgarage=' . $row['pjs_drivers_id'] . '">' . $row['driver_name'] . '</a></td></tr>';
		}
		$table .= '</table>';
		
		return $table;
	}
	
	public function getDriver($driver_id) {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "select * from pjs_drivers where pjs_drivers_id = $driver_id";
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();
		$driver_name = $row['driver_name'];
		return $driver_name;
		
	}
	
	public function getPagename() {
		return $this->pagename;
	}
	
}