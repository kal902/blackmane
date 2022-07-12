<?php
include_once "models/Admin.php";
include_once "config/database.php";
include_once "models/Artists.php";
include_once "models/Musics.php";
include_once "router/Request.php";
include_once "models/Musics.php";
include_once "upload_manager.php";

class Controller{


	function __construct($req){
		$this->request = $req;
		$this->msg = false;
	}

	function load_home(){
		include_once "views/main.php";
	}

	function load_admin(){
		session_start();

		if(isset($_SESSION['user'])){
			if($_SESSION['user']=='admin'){
				include_once "views/admin.php";
			}
		}else{
			// redirect to login page.
			session_destroy();
			$this->show_login();
		}
	}

	function show_login(){
		$msg = $this->msg;
		include_once "views/login.php";
	}

	function auth(){
		$data = $this->request->getBody();
		$usr_name = $data['user_name'];
		$pass = $data['passwd'];

		$acc = new Admin();
		if($acc->check_creds($usr_name, $pass)){
			/*
				if credentials are correct set the session variable an redirect to admin page.
			*/
			session_start();
			$_SESSION['user'] = 'admin';
			$this->load_admin();
		}else{

			$this->msg = 'password or user name is incorrect!'; // will be displayed when login page is loaded
			$this->show_login();
		}
	}

	function log_out(){
		session_start();
		session_destroy();
		$this->show_login();
	}
	// return an html component populated with the data
	function load_artist_view($page){

	}

	function add_aritst(){
		
		if(isset($_POST['artist_name']) && isset($_POST['artist_detail']) && isset($_POST['info'])){
				//post data
			$artist_name = $_POST['artist_name'];
			$artist_detail = $_POST['artist_detail'];
			$additional_info = $_POST['info'];

			$upmgr = new UploadManager();
			$status = $upmgr->upload_image();
			if($status==1){
					//save to database
				$image_name = $upmgr->get_image_name();
				$artist = new Artists();
				$status = $artist->add_artist($image_name,$artist_name,$artist_detail,$additional_info);
				if($status==true){
					echo "success";
				}else{
					echo $upmgr->get_log();
				}
			}else{
				echo $upmgr->get_log();
			}

			
		}else{
			echo "form is not completed";
		}
	}

	function get_artists(){
		$art = new Artists();
		echo json_encode($art->get_artists());
	}

	function add_music(){
		$data = $this->request->getBody();
		extract($data);
		// &#10; means new line in a text writen in textarea html element
		// replace &#10; with <br> before adding to db
		$cleaned_lyrics = str_replace("&#10;", "<br>", $lyrics);
		$arts = new Artists();
		$artist_id = $arts->get_id_by_name($artist_name);
		$response = array('status'=>0);// 0 = fail
		if(!$artist_id){ // means artist was not found
			$response["msg"] = 'artist doesnt exist';
			echo json_encode($response); 
			return;
		}
		$mic = new Musics();
		$res = $mic->add_music($artist_id, $music_title, $cleaned_lyrics);
		if($res!=true){
			$response['msg'] = 'sorry, internal error have occured, please try again';
			echo json_encode($response);
		}else{
			$response['status'] = 1;
			echo json_encode($response);
		}

	}

	function get_musics(){
		$data = $this->request->getBody();
		$page = $data['page'];

		$msc = new Musics();
		$musics = $msc->get_musics($page);

		$art = new Artists();
		// for each music get the associated artist name.
		$size_musics = count($musics);
		for($i=0;$i<$size_musics;$i++){
			$music = $musics[$i];
			$artist_name = $art->get_artistName_byid($music['artist_id']);
			if($artist_name!=null){
				$music['artist_name'] = $artist_name;
				$musics[$i] = $music; // replace old music value with the new updated one
			}
		}
		echo json_encode($musics);

	}

	function artist_detail(){
		$data = $this->request->getBody();
		$id = $data['id'];

		$ar = new Artists();
		$artist_detail = $ar->get_artist($id);

		$msc = new Musics();
		$musics = $msc->get_by_artistid($id);

		$res = array();
		if($musics==null){
			$res['musics'] = 0;
		}else{
			$res['musics'] = $musics;
		}
		
		$res['artist_detail'] = $artist_detail;

		echo json_encode($res);
	}

	function lyrics_view(){
		$data = $this->request->getBody();
		$id = $data['music_id'];

		$msc = new Musics();
		$lyrics = $msc->get_lyrics($id);
		if($lyrics==null)
			die("{'status':0}");
		echo json_encode(array("status"=>1, "lyrics"=>$lyrics));
	}

	function search(){
		$data = $this->request->getBody();
		$query = $data['query'];

		$musics_found = array();
		$artist_found = array();

		$msc = new Musics();
		$art = new Artists();

		$artists = $art->search_by_name($query);
		foreach($artists as $artist){
			$msc_found = $msc->get_by_artistid($artist['id']);
			foreach($msc_found as $music){
				array_push($musics_found, $music);
			}
			array_push($artist_found, $artist);
		}

		$musics = $msc->search_by_title($query);
		foreach($musics as $music){
			array_push($musics_found, $music);
		}

		$response = array();
		$response['artist'] = $artist_found;
		$response['musics'] = $musics_found;

		echo json_encode($response);
	}

	function is_admin(){
		session_start();

		if(isset($_SESSION['user'])){
			if($_SESSION['user']=='admin'){
				echo 'yes';
			}else{
				echo 'no';
			}
		}else{
			echo 'no';
		}
	}

	function delete_music(){
		$data = $this->request->getBody();
		$id = $data['id'];

		$msc = new Musics();
		if($msc->delete_music($id)){
			echo json_encode(array('status'=>0)); // successfull
		}else{
			echo json_encode(array('status'=>1)); // error
		}
	}

	function delete_artist(){
		$data = $this->request->getBody();
		$artist_id = $data['id'];
		$delete_musics = $data['delete_musics']; // if 0/true all musics associated with this id will be deleted

		$art = new Artists();

		if($art->delete_artist($id)){
			if($delete_musics==0){
				$msc = new Musics();
				$msc->delete_by_artist_id($artist_id);
			}
			echo json_encode(array('status'=>0));
		}else{
			echo json_encode(array('status'=>0));
		}
	}

	function change_password(){
		$data = $this->request->getBody();
		$old_pass = $data['old_pass'];
		$new_pass = $data['new_pass'];

		// TODO 

	}


}
?>