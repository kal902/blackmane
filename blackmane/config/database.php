<?php
	class Database{
		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $db_name = "blackmane";
		private $conn;
		function get_connection(){
			$this->conn = mysqli_connect($this->host, $this->user, $this->pass,$this->db_name);
			if(mysqli_connect_errno()){
				return $this->init(); // if error, assume error is dueto not existent database
			}else{
			 	return $this->conn;
			}
			
		}
		function end_connection(){
			mysqli_close($this->conn);
		}

		// create database with the name $db_name, then return conn obj after selecting the new database
		function init(){
			$stmt = "CREATE DATABASE '$this->db_name'";

			$temp_conn = mysqli_connect($this->host, $this->user, $this->pass);
			if (mysqli_connect_errno()){
				return false;
			}else{
				if(mysqli_query($temp_conn,$stmt)){
					if(mysqli_query($temp_conn, "SELECT DB '$this->db_name'")){
						return $temp_conn;
					}

				}
			}
			return false;
		}
	}
?>