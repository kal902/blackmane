<?php
include_once "config/database.php";
/*
table Artists: id, image_path(Text), artist_name(Text), artist_detail(Text), additional_info(text), date_added(date) 
*/
class Artists{
	private $tbl_name = "artists";

	function __construct(){
		$db = new Database();
		$this->conn = $db->get_connection();
		$this->current_date = date("Y-m-d");
	}

	function add_artist($img_name, $artist_name, $artist_detail, $additional_info){
		$id = $this->generate_id();
		$stmt = "INSERT INTO $this->tbl_name(id, artist_name, artist_detail, additional_info, img_name, date_added)";
		$stmt.=" VALUES('$id', '$artist_name', '$artist_detail', '$additional_info', '$img_name', '$this->current_date')";
		if(mysqli_query($this->conn, $stmt)){
			return true;
		}
		return mysqli_error($this->conn);
	}

	function update_artist($new_data, $img_name){
		extract($new_data);
		$stmt = "UPDATE $this->tbl_name SET img_name='$img_name', artist_name='$artist_name', artist_detail='$artist_detail', additional_info='$additional_info' WHERE id=$artist_id";
		if(mysqli_query($this->conn, $stmt)){
			return true;
		}
		return false;
	}

	function delete_artist($artist_id){
		if (mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE id='$artist_id'")){
            return true;
        }
        return false;
	}

	function get_artists(){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name");
		$artists = array();
		if(mysqli_num_rows($query)>0){
			while($row=mysqli_fetch_assoc($query)){
                array_push($artists, $row);
            }
		}
		return $artists;
	}

	function get_artist($id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE id='$id'");
		if(mysqli_num_rows($query)>0){
			return mysqli_fetch_assoc($query);
		}
		return null;
	}
	// helper functions

	function artist_exists($artist_id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE id='$artist_id'");
        if(mysqli_num_rows($query)>0){
            return true;
        }
        return false;

	}

	private function generate_id(){
		$new_id;
		while(true){
			$new_id = rand(1,1000);
			if($this->artist_exists($new_id)!=true){
				break;
			}
		}
		return $new_id;
	}

	function get_by_name($name){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE artist_name='$name'");
		if(mysqli_num_rows($query)>0){
			$row = mysqli_fetch_assoc($query); // get only the first row
			return $row;
		}
		return null;
	}

	function get_artistName_byid($id){
		$stmt = "SELECT artist_name FROM $this->tbl_name WHERE id='$id'";
		$query = mysqli_query($this->conn, $stmt);
		if(mysqli_num_rows($query)>0){
			$row = mysqli_fetch_assoc($query);
			return $row['artist_name']; // contains only artist name
		}
		return null;
	}

	function search_by_name($name){
		$artists = $this->get_artists();
		$artists_found = array();
		foreach($artists as $artist){
			$artist_name = $artist['artist_name'];

			if(strpos($artist_name, $name)!==false){
				array_push($artists_found, $artist);
			}
		}
		return $artists_found;
	}

}

?>