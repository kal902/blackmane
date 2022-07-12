<?php
include_once "src/router/Router.php";
include_once "src/router/Request.php";
include_once "src/controller.php";

$router = new Router(new Request);

$router->get("/", function($request){
	$ctrl = new Controller($request);
	$ctrl->load_home();
});

$router->get("/login", function($request){
	$ctrl = new Controller($request);
	$ctrl->show_login();
});

$router->post("/log_out", function($request){
	$ctrl = new Controller($request);
	$ctrl->log_out();
});

$router->get("/admin", function($request){
	$ctrl = new Controller($request);
	$ctrl->load_admin();
});

$router->post("/auth", function($request){
	$ctrl = new Controller($request);
	$ctrl->auth();
});

$router->post("/add_artist", function($request){
	$ctrl = new Controller($request);
	$ctrl->add_aritst();
});

$router->post("/get_artists", function($request){
	$ctrl = new Controller($request);
	$ctrl->get_artists();
});

$router->post("/add_music", function($request){
	$ctrl = new Controller($request);
	$ctrl->add_music();
});

$router->post("/musics", function($request){
	$ctrl = new Controller($request);
	$ctrl->get_musics();

});

$router->post("/artist_detail", function($request){
	$ctrl = new Controller($request);
	$ctrl->artist_detail();

});

$router->post("/lyrics", function($request){
	$ctrl = new Controller($request);
	$ctrl->lyrics_view();

});

$router->post("/search", function($request){
	$ctrl = new Controller($request);
	$ctrl->search();

});

$router->post("/is_admin", function($request){
	$ctrl = new Controller($request);
	$ctrl->is_admin();

});

$router->post("/delete_music", function($request){
	$ctrl = new Controller($request);
	$ctrl->delete_music();

});

$router->route();

?>
