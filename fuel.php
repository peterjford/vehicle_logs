<?php
	/*
	 * Written by Peter J. Ford
	 * 2015-05-12
	 * 2015-05-22 - changed to class
	 * 2015-05-26 - updated functions
	 * 2015-06-01 - added cost per mile
	 * 2015-06-02 - added form to enter fuel purchase
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
	private $header_row = '<tr><th>Gap</th><th>Date</th><th>Odometer</th><th>Miles</th><th>Fuel</th><th>Gallons</th><th>Cost</th><th>City %</th><th>Highway %</th><th>MPG</th><th>Notes</th><th>delete</th></tr>';
	private $fuel_columns = array('fuel_gap', 'fuel_date', 'fuel_odo', 'fuel_type', 'fuel_gallons', 'fuel_cost', 'fuel_city_percent', 'fuel_notes');
	
	public function __construct() {
		
	}
	
	public function getFuelLog($vehicle_id) {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "select * from pjs_fuel where fuel_garage_id = '$vehicle_id'";
		$garage = new Garage();
		$vehicle = $garage->getVehicle($vehicle_id);
		$result = $mysqli->query($query);
		
		$last_fuel_type = '';
		$previous_miles = 0;
		$total_miles = 0;
		$total_gallons = 0;
		$total_cost = 0;
		$total_city = 0;
		$city_count = 0;
		$mpg_count = 0;
		$mpg_total = 0;
		
		$table = '<table>';
		$table .= '<tr><th colspan=12 align="center">' . $vehicle . '</th></tr>';
		$table .= $this->header_row;
		
		if ($result->num_rows == 0) {
			$table .= '<tr><td colspan=10 align="center">No Data Available</td></tr>';
		}
		else {
			while ($row = $result->fetch_assoc()) {
				$table .= '<tr>';
				foreach ($this->fuel_columns as $var) {
					if ($var == 'fuel_gap' && $row['fuel_gap'] == '1') {
						$previous_miles = 0;
						$total_miles = 0;
						$total_gallons = 0;
						$total_cost = 0;
						$total_city = 0;
						$city_count = 0;
						$mpg_count = 0;
						$mpg_total = 0;
					}
					if ($var == 'fuel_gallons') {
						$gallons = $row[$var];
						$total_gallons += $gallons;
						$table .= '<td align="right">' . $row[$var] . '</td>';
					}
					else if ($var == 'fuel_cost') {
						$total_cost += $row['fuel_cost'];
						$table .= '<td align="right">' . $row[$var] . '</td>';
					}
					else if ($var == 'fuel_odo') {
						if ($previous_miles == 0) {
							$miles = '---';
						}
						else {
							$miles = ($row[$var] - $previous_miles);
							$total_miles += $miles;
						}
						$previous_miles = $row[$var];
						$table .=  '<td align="center">' . $row[$var] . '</td><td align="right">' . $miles . '</td>';
					}
					else if ($var == 'fuel_city_percent') {
						$fuel_highway_percent = 100 - $row[$var];
						$city_count++;
						$total_city += $row[$var];
						if ($miles == '---') {
							$mpg = $miles;
						}
						else {
							$mpg = round(($miles / $gallons), 1);
							$mpg_count++;
							$mpg_total += $mpg;
						}
						$table .= '<td align="center">' . $row[$var] . '</td><td align="center">' . $fuel_highway_percent . '</td><td align="right">' . $mpg . '</td>';
					}
					else {
						if ($var == 'fuel_type') {
							$last_fuel_type = $row[$var];
						}
						$table .= '<td> &nbsp;' . $row[$var] . '</td>';
					}
				}
				$table .= $this->removePurchaseForm($row['pjs_fuel_id'], $vehicle_id);
				$table .= '</td></tr>';
			}
		}
		if ($total_miles != 0) {
			$table .= '<tr><th colspan=3>Total and Averages: </th><th>' . $total_miles . '</th><th> </th><th>' . $total_gallons . '</th><th>' . $total_cost . '</th><th>' . round(($total_city / $city_count), 1) . '</th><th>' . round((100 - ($total_city / $city_count)), 1) . '</th><th>' . round(($mpg_total / $mpg_count), 1) . '</th></tr>';
			$table .= '<tr><th colspan=4>Cost Per Mile: </th><th>' . round(($total_cost / $total_miles), 2) . '</th><th colspan=5></th></tr>';
		}
		$table .= $this->fuelPurchaseForm($vehicle_id, $last_fuel_type);
		$table .= '</table>';
		
		return $table;
	}
	
	public function fuelPurchaseForm($vehicle_id, $last_fuel_type) {
		$fuelform = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST" oninput="x.value=100-parseInt(a.value)">';
		$fuelform .= '<input type="hidden" name="fuel_garage_id" value="' . $vehicle_id . '">';
		$fuelform .= '<tr><td><input type="checkbox" name="fuel_gap" value="1">gap</td>';
		$fuelform .= '<td><input type="text" name="fuel_date" value="' .date('Y-m-d H:i:s') . '"></td>';
		$fuelform .= '<td><input type="text" name="fuel_odo"></td><td></td>';
		$fuelform .= '<td><input type="text" name="fuel_type" value="' . $last_fuel_type . '" size="15"></td>';
		$fuelform .= '<td><input type="text" name="fuel_gallons" size="10"></td>';
		$fuelform .= '<td><input type="text" name="fuel_cost" size="10"></td>';
		$fuelform .= '<td><input type="text" id="a" name="fuel_city_percent" size="8"></td>';
		$fuelform .= '<td><input type="text" id="x" name="fuel_highway" size="8"></td><td></td>';
		$fuelform .= '<td><input type="text" name="fuel_notes"></td></tr>';
		$fuelform .= '<tr><th colspan="10"><input type="submit" name="add_fuel" value="Add Fuel Purchase"></th></tr></form>';
		
		return $fuelform;
	}
	
	public function fuelPurchase($fueldata) {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "insert into pjs_fuel (fuel_garage_id, ";
		foreach ($this->fuel_columns as $val) {
			if (isset($fueldata[$val])) {
				$query .= $val;
				if ($val != "fuel_notes") {
					$query .= ', ';
				}
			}
		}
		$query .= ') values (' . $fueldata['fuel_garage_id'] . ', ';
		foreach ($this->fuel_columns as $val) {
			if (isset($fueldata[$val])) {
				$query .= "'" . $fueldata[$val] . "'";
				if ($val != "fuel_notes") {
					$query .= ', ';
				}
			}
		}
		$query .= ')';
		
		$result = $mysqli->query($query);
	}
	
	public function editPurchaseForm($fueldata) {
		$editform = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
		$editform .= '<input type="hidden" name="pjs_fuel_id" value="' . $fueldata['pjs_fuel_id'] . '">';
		$editform .= '<input type="hidden" name="fuel_garage_id" value="' . $fueldata['fuel_garage_id'] . '">';
		$editform .= '<tr><td><input type="checkbox" name="fuel_gap" value="1"';
		if (isset($fueldata['fuel_gap'])) {
			$editform .= ' checked';
		}	
		$editform .= '>gap</td>';
		$editform .= '<td><input type="text" name="fuel_date" value="' . $fueldata['fuel_date'] . '"></td>';
		$editform .= '<td><input type="text" name="fuel_odo" value="' . $fueldata['fuel_odo'] . '"></td><td></td>';
		$editform .= '<td><input type="text" name="fuel_type" value="' . $fueldata['fuel_type'] . '" size="15"></td>';
		$editform .= '<td><input type="text" name="fuel_gallons" size="10" value="' . $fueldata['fuel_gallons'] . '"></td>';
		$editform .= '<td><input type="text" name="fuel_cost" size="10" value="' . $fueldata['fuel_cost'] . '"></td>';
		$editform .= '<td><input type="text" name="fuel_city_percent" size="8" value="' . $fueldata['fuel_city_percent'] . '"></td>';
		$editform .= '<td><input type="text" name="fuel_highway" size="8" value="' . 100-$fueldata['fuel_city_percent'] . '"></td><td></td>';
		$editform .= '<td><input type="text" name="fuel_notes" value="' . $fueldata['fuel_notes'] . '"></td></tr>';
		$editform .= '<tr><th colspan="10"><input type="submit" name="update_fuel" value="Update Fuel Purchase"></th></tr></form>'; 	
	}
	
	public function editPurchase($pjs_fuel_id) {
	
	}
	
	public function removePurchaseForm($pjs_fuel_id, $vehicle_id) {
		$removeform = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><input type="hidden" name="vehicle_id" value="' . $vehicle_id . '"><input type="hidden" name="pjs_fuel_id" value="' . $pjs_fuel_id . '"><td><input type="submit" name="remove_fuel_purchase" value="X"></form>';
	
		return $removeform;
	}
	
	public function removePurchase($pjs_fuel_id) {
		$dbconnect = new dbconnect();
		$mysqli = $dbconnect->getConnection();
		$query = "delete from pjs_fuel where pjs_fuel_id = $pjs_fuel_id";
		$result = $mysqli->query($query);
	}
	
	public function getPagename() {
		return $this->pagename;
	}
}	
?>
