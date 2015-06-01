<?php
	/*
	 * Written by Peter J. Ford
 	 * 2015-05-12
 	 * 2015-05-18 - changed to class 
 	 * 2015-05-20 - added link to drivers vehicles
	 * 2015-06-01 - added "addDriverForm" and "addDriver"
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
			$table .= '<tr><td></td><td><a href="view.php?driversgarage=' . $row['pjs_drivers_id'] . '">' . $row['driver_name'] . '</a></td>';
			$table .= $this->removeDriverForm($row['pjs_drivers_id']);
			$table .= '</td></tr>';
		}
		$table .= '<tr><th>Add Driver:</th>';
		$table .= $this->addDriverForm();
		$table .= '</td></tr>';
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
	
	public function addDriverForm() {
		$addform = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><td><input type="text" name="driver_name"></td><td><input type="submit" name="add_driver" value="Add"></form>';
			
		return $addform;
	}

	public function addDriver($driver_name) {
	        $dbconnect = new dbconnect();
                $mysqli = $dbconnect->getConnection();
                $query = "insert into pjs_drivers (driver_name) values ('$driver_name')";
                $result = $mysqli->query($query);
	}

        public function removeDriverForm($driver_id) {
                $removeform = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><input type="hidden" name="driver_id" value="' . $driver_id . '"><td><input type="submit" name="remove_driver" value="X"></form>';

                return $removeform;
        }

        public function removeDriver($driver_id) {
                $dbconnect = new dbconnect();
                $mysqli = $dbconnect->getConnection();
                $query = "delete from pjs_drivers where pjs_drivers_id = $driver_id";
                $result = $mysqli->query($query);
        }
	
	public function getPagename() {
		return $this->pagename;
	}
	
}
