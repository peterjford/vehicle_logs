<?php
class dbconnect extends mysqli {

	public function getConnection() {
		$mysqli = mysqli_connect("<insert your mysql hostname here", "<insert your mysql username here>", "<insert your password here>", "pjs_vehicles");
		return $mysqli;
	}
}
