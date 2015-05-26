<?php
	/*
	 * Written by Peter J. Ford
	 * 2015-05-12
	 * 2015-05-22 - changed to class
	 * 2015-05-26 - updated functions
	 */

/*
pjs_fuel_id			int(11)			NO	PRI	NULL	auto_increment
fuel_garage_id		int(11)			YES		NULL	
fuel_date			datetime		YES		NULL	
fuel_odo			int(11)			YES		NULL	
fuel_type			varchar(10)		YES		NULL	
fuel_gallons		decimal(6,3)	YES		NULL	
fuel_cost			decimal(6,2)	YES		NULL	
fuel_city_percent	tinyint(4)		YES		NULL	
fuel_notes			varchar(255)	YES		NULL	
*/

require_once('config/db.php');
require_once('garage.php');

class Fuel {
	
	private $pagename = "PJ's Fuel Log";
	private $header_row = '<tr><th>Date</th><th>Odometer</th><th>Miles</th><th>Fuel</th><th>Gallons</th><th>Cost</th><th>City %</th><th>Highway %</th><th>MPG</th><th>Notes</th></tr>';
	private $fuel_columns = array('fuel_date', 'fuel_odo', 'fuel_type', 'fuel_gallons', 'fuel_cost', 'fuel_city_percent', 'fuel_notes');
	
	public function __construct() {
		
	}
	
	public function getFuelLog($vehicle_id) {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "select * from pjs_fuel where fuel_garage_id = '$vehicle_id'";
		$garage = new Garage();
		$vehicle = $garage->getVehicle($vehicle_id);
		$result = $mysqli->query($query);
		
		$previous_miles = 0;
		
		$table = '<table>';
		$table .= '<tr><th colspan=10 align="center">' . $vehicle . '</th></tr>';
		$table .= $this->header_row;
		
		if ($result->num_rows == 0) {
			$table .= '<tr><td colspan=10 align="center">No Data Available</td></tr>';
		}
		else {
			while ($row = $result->fetch_assoc()) {
				$table .= '<tr>';
				foreach ($this->fuel_columns as $var) {
					if ($var == 'fuel_gallons') {
						$gallons = $row[$var];
					}
					if ($var == 'fuel_odo') {
						if ($previous_miles == 0) {
							$miles = '---';
						}
						else {
							$miles = ($row[$var] - $previous_miles);
						}
						$previous_miles = $row[$var];
						$table .=  '<td align="center">' . $row[$var] . '</td><td align="right">' . $miles . '</td>';
					}
					else if ($var == 'fuel_city_percent') {
						$fuel_highway_percent = 100 - $row[$var];
						if ($miles == '---') {
							$mpg = $miles;
						}
						else {
							$mpg = round(($miles / $gallons), 1);
						}
						$table .= '<td align="center">' . $row[$var] . '</td><td align="center">' . $fuel_highway_percent . '</td><td>' . $mpg . '</td>';
					}
					else {
						$table .= '<td>' . $row[$var] . '</td>';
					}
				}
				$table .= '</tr>';
			}
		}
		$table .= '</table>';
		
		return $table;
	}
	
	public function enterFuelPurchase($vehicle_id, $fueldata) {
		// $fueldata is an array with values from enter fuel purchase form?
	}
	
	public function editFuelLog() {
	
	}
	
	public function getPagename() {
		return $this->pagename;
	}
}	
?>