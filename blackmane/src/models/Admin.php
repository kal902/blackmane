<?php
include_once "config/database.php";
// tbl admins:- user_name, password(Text)
class Admin{
	private $tbl_name = "accounts";
	function __construct(){
		$db = new Database();
		$this->conn = $db->get_connection();

	}
	
	function add_account($name, $pass){
		$password = md5($pass);
		$stmt = "INSERT INTO $this->tbl_name(user_name, password)";
		$stmt.= "VALUES ('$name', '$password')";

		if(mysqli_query($this->conn, $stmt)){
			return true;
		}
		return false;
	}

	function check_creds($user_name, $pass){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE user_name='$user_name'");
		if(mysqli_num_rows($query)>0){
			$row = mysqli_fetch_array($query);
			$password = $row['password'];
			if(md5($pass)==$password){
				return true;
			}
		}
		return false;
	}

	function account_exists($user_name){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE user_name='$user_name'");
		if(mysqli_num_rows($query)>0){
			return true;
		}
		return false;
	}

	function remove_account($user_name,$pass){

	}

	function change_password($user_name, $_pass, $new_pass){
		
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE user_name='$user_name'");
		if(mysqli_num_rows($query)>0){
			$row = mysqli_fetch_array($query);
			$password = $row['password'];
			$new_pass_md5 = md5($new_pass);
			if(md5($_pass)==$password){// check if the old password is correct
				$stmt = "UPDATE $this->tbl_name SET password='$new_pass_md5' WHERE user_name='$user_name'";
				if(mysqlli_query($this->conn, $stmt)){
					return true;
				}
			}
		}
		return false;
	}


}
?>