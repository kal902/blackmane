<?php
include_once "Artists.php";
// tbl musics: music_id(int,pr key), aritst_id(int), music_title(text), lyrics(long text), date_added(date)
class Musics{
	private $tbl_name = "musics";
	function __construct(){
		$db = new Database();
		$this->conn = $db->get_connection();
		$this->current_date = date("Y-m-d");
	}

	function add_music($artist_id, $music_title, $lyrics){
		$music_id = $this->generate_id();
		$artists = new Artists();
		if(!$artists->artist_exists($artist_id)){
			return "artist doesnt exist";
		}
		
		$stmt = "INSERT INTO $this->tbl_name(music_id, artist_id, music_title, lyrics, date_added) ";
		$stmt.= "VALUES('$music_id', '$artist_id', '$music_title', '$lyrics', '$this->current_date')";
		if(mysqli_query($this->conn, $stmt)){
			return true;
		}
		return mysqli_error($this->conn);
	}

	function get_musics($index){
		$offset = ($index*10)-10;
		$stmt = "SELECT music_id, artist_id, music_title FROM $this->tbl_name LIMIT 10 OFFSET $offset";
		$query = mysqli_query($this->conn, $stmt);
		$musics = array();
		if(mysqli_num_rows($query)>0){
			while($music=mysqli_fetch_assoc($query)){
                array_push($musics, $music);
            }
		}
		return $musics;
	}

	function delete_music($music_id){
		if (mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE music_id='$music_id'")){
            return true;
        }
        return false;
	}

	function delete_by_artist_id($artist_id){
		if (mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE artist_id='$artist_id'")){
            return true;
        }
        return false;
	}
	// $new_data : an assossiative array
	function update_music($music_id, $new_data){
		extract($new_data);
		$stmt = "UPDATE $this->tbl_name SET artist_id='$artist_id', music_title='$music_title', lyrics='$lyrics' WHERE music_id=$music_id";
		if(mysqli_query($this->conn, $stmt)){
			return true;
		}
		return false;
	}

	function music_exists($music_id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE music_id=$music_id");
        if(mysqli_num_rows($query)>0){
            return true;
        }
        return false;
	}

	function title_exists($title){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE music_title=$title");
        if(mysqli_num_rows($query)>0){
            return true;
        }
        return false;
	}
	// generate a new unique id for the music to be added
	function generate_id(){
		$new_id;
		while(true){
			$new_id = rand(1,1000);
			if($this->music_exists($new_id)!=true){
				break;
			}
		}
		return $new_id;
	}

	function get_by_artistid($artist_id){
		$query = mysqli_query($this->conn, "SELECT music_id, music_title,artist_id FROM $this->tbl_name WHERE artist_id='$artist_id'");
		$musics = array();
		if(mysqli_num_rows($query)>0){
			
			while($music=mysqli_fetch_assoc($query)){
				array_push($musics, $music);
			}
			return $musics;
		}
		return $musics;
	}

	function get_lyrics($music_id){
		$query = mysqli_query($this->conn, "SELECT lyrics FROM $this->tbl_name WHERE music_id='$music_id'");
		if(mysqli_num_rows($query)>0){
			$row = mysqli_fetch_assoc($query);
			return $row['lyrics'];
		}
		return null;
	}

	function get_by_title($title){
		$query = mysqli_query($this->conn, "SELECT music_id, music_title,artist_id FROM $this->tbl_name WHERE music_title='$title'");
		$musics = array();
		if(mysqli_num_rows($query)>0){
			
			while($music=mysqli_fetch_assoc($query)){
				array_push($musics, $music);
			}
			return $musics;
		}
		return $musics;
	}

	function search_by_title($title){
		$query = mysqli_query($this->conn, "SELECT music_id,music_title, artist_id FROM $this->tbl_name");
		$musics_found = array();
		if(mysqli_num_rows($query)>0){
			while($music=mysqli_fetch_assoc($query)){
                $music_title = $music['music_title'];

				if(strpos($music_title, $title)!==false){
					array_push($musics_found, $music);
				}
            }
		}
		
		return $musics_found;
	}

}

?>