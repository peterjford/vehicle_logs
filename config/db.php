<?php
class dbconnect extends mysqli {

	public function getConnection() {
		$mysqli = mysqli_connect("127.0.0.1", "root", "suitepay", "pjs_vehicles");
		return $mysqli;
	}
}
