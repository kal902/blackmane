<title>BLACKMANE</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="../css/w3-colors-metro.css">
<link rel="stylesheet" href="../css/style.css">

<style>
  .view{
  display:none;
}
</style>

<body>

<!-- Sidebar/menu (default width is 300px)-->
<nav class="side w3-sidebar w3-metro-darken w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:250px;font-weight:bold;" id="mySidebar">
    <br>

    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">☰</a>


    <div id='search_container' class='w3-panel'>
      <input id='search' style='border:0px' class="w3-hide-large w3-input w3-metro-darken" type="text" placeholder="search...">
    </div>

    <br>

    <a href="#home" onclick="loadview('home')"><img src="res/home2.png" alt="doctor" width="33" height="33"><i class="fa fa-fw"></i> Home</a>
    <a href="#Artists" onclick="load_artists()"><img src="res/artist.png" alt="doctor" width="30" height="30"><i class="fa fa-fw"></i> Artists</a>
    <a href="#Musics" onclick="load_musics(1)"><img src="res/music2.png" alt="doctor" width="30" height="30"><i class="fa fa-fw"></i> Musics</a>
    <a href="#About" onclick="loadview('home')"><i class="fa fa-fw"></i> About us</a>

</nav>

<?php include_once 'header.php'; ?>



<!-- !PAGE CONTENT! (margin-left:340px 40px greater than the default sidebar width)-->
<div class="w3-main w3-dark" style="margin-left:260px;margin-right:10px">

	


  <?php
    include_once 'artists_view.php';
    include_once 'musics_view.php';
    include_once 'detail_view.php';
    include_once 'lyrics_view.php';
    include_once 'search_result_view.php';
    include_once 'home.php';
  ?>

  

  

<!-- End page content -->
</div>


<script type="text/javascript" src="../lib/jquery.min.js"></script>
<script>
var on_back = []; // name of a view to load when backbutton is pressed
//document.getElementById('musics_list_scrollable').style.height = (screen.height-258)+"px";
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}


function loadview(id) {
    var i;
    var x = document.getElementsByClassName("view");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    document.getElementById(id).style.display = "block";
    w3_close();
}

function init_element_size(){
  var newWidth = window.innerWidth;
    //var newHeight = window.innerHeight; 
    //console.log(newWidth);
    var sticky = document.getElementsByClassName("sticky"); // header like elements that needs to be resized on screen change.
    document.getElementById('progress_bar').style.display = 'none';
    if(newWidth<600){ // if < 600 assume mobile view
      
      document.getElementById('con_detail').style.marginTop = '75px';
      document.getElementById("musics_list_scrollable").style.marginTop = "75px";
      document.getElementById('lyrics_head').style.marginTop = '75px';
      document.getElementById('header_big').style.display = 'none';
    }else{
      
      document.getElementById("musics_list_scrollable").style.marginTop = "0px";
      document.getElementById('con_detail').style.marginTop = '10px';
      document.getElementById('lyrics_head').style.marginTop = '0px';
      document.getElementById('header_big').style.display = 'block';
    }
}

var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}

var progress_len = 0;
function progress(){
  var bar = document.getElementById('progress_bar');
  var prog = document.getElementById('progress');
  bar.style.display = 'block';

  if(progress_len<60){
    prog.style.width = progress_len+'%';
    progress_len++;
  }else{
    return;
  }
  setTimeout(progress, 10);
}

function load_artists(){
  //loadview("loader");
  // check if artists data have been loaded before.
  /* error is made purposfully with the id"artist", maybe reloading each time when sidemenu item is clicked is best
     when new values are being added to the database, so the view will be in sync.
     or make a request asking if a new data have been added then if yes, request for data and refresh the view container.
  */
  var artist = document.getElementsByClassName("artist"); // error is made purposfully with the id "artist" -> "artists"
  if(artist.length>0){
    // artist data have been loaded before, so just display the artists view.
    // todo: ask if there is new data added, so the view will not be outdated, then if "yes" request for the data and reconstruct view.
    loadview("artists_view");
  }else{
    // retreive artists data from server
    w3_close();
    //progress();

    $.post('/get_artists',

                {test_data:"data"},

                function(data){
                    var artists = JSON.parse(data);
                    var artists_view = document.getElementById("artists_view");
                    artists_view.innerHTML = "<div class='w3-row-padding'>";
                    for(var i=0;i<artists.length;i++){
                        // for each artist do ...
                        var artist = artists[i];
                        //artists_view.innerHTML += create_artist_card(artists[i]);
                        var img = document.createElement('img');
                        img.src = "../uploads/images/"+artist.img_name;
                        img.style.width = '100%';

                        // container for artist detail
                        var span_artistName = document.createElement('span');
                        span_artistName.className = 'w3-cursive';
                        span_artistName.style.color = "#34568b";
                        span_artistName.innerHTML = artist.artist_name;
                        var div = document.createElement('div');
                        div.className = 'w3-container';
                        div.appendChild(span_artistName);

                        // container for holding image and details
                        var div2 = document.createElement('div');
                        div2.className = 'w3-black';
                        div2.appendChild(img);
                        div2.appendChild(div);

                        // main container
                        var div_main = document.createElement('div');
                        div_main.className = 'artists w3-row-padding w3-col m4 w3-margin-bottom';
                        div_main.setAttribute('onclick', "load_artist_detail('"+artist.id+"');");
                        div_main.appendChild(div2);

                        artists_view.appendChild(div_main);

                        //console.log(create_artist_card(artists[i]));
                        //console.log(artists[i]);
                    }
                    artists_view.innerHTML += "</div>";
                    document.getElementById('progress').style.width = '100%';
                    document.getElementById('progress_bar').style.display = 'none';
                    loadview("artists_view");

                });
  }
}


function load_lyrics(onback, musicid, artistid, musictitle, artistname){
  // first parameter is name of the view to show when backbutton is pressed.
  on_back.push(onback);
  $.post('/lyrics',
           {music_id:musicid},

           function(data){
            var res = JSON.parse(data);
            document.getElementById('lyrics').innerHTML = res.lyrics;

            loadview('lyrics_view');
           });    
}

function load_artist_detail(id){
  on_back.push('artists_view');

  $.post('/artist_detail', 

        {id:id},

        function(data){
          var res = JSON.parse(data);
          var detail = res.artist_detail;
          var musics = res.musics;

          document.getElementById('td_name').innerHTML = detail.artist_name;
          document.getElementById('td_detail').innerHTML = detail.artist_detail;
          document.getElementById('td_info').innerHTML = detail.additional_info;
          document.getElementById('img_detail').src = "../uploads/images/"+detail.img_name
          var musics_made = musics.length;
          document.getElementById('td_musicsmade').innerHTML = musics_made;

          if(musics_made>0){
            var ul = document.getElementById("ul_music_list2");
                  ul.innerHTML = "";
                  for(var i=0;i<musics.length;i++){
                    var music = musics[i];

                    var li = document.createElement("li");
                    li.class = "w3-bar"


                    var div = document.createElement("div");
                    div.className = "w3-bar-item";
                    div.style.width = "100%";   
                    div.setAttribute("onclick", "load_lyrics('detail_view','"+music.music_id+"','"+detail.artist_id+"','"+music.music_title+"','"+detail.artist_name+"');");
                    var span_title = document.createElement("span");
                    span_title.style.color = "#34568b";
                    span_title.className = "w3-large w3-wide";
                    span_title.innerHTML = music.music_title;

                    div.appendChild(span_title);
                    li.appendChild(div);


                    ul.appendChild(li);

                  }
          }else{

          }
          loadview('detail_view');
        });
  
}

function delete_music(id){
  alert(id);
}

function load_musics(page){
  $.post('/musics',

                {page:page},

                function(data){
                  var isAdmin = is_admin(); // if admin remove buttons will be constructed
                  var musics = JSON.parse(data);
                  var ul = document.getElementById("ul_music_list");
                  ul.innerHTML = "";
                  for(var i=0;i<musics.length;i++){
                    var music = musics[i];

                    var li = document.createElement("li");
                    li.className = "w3-bar";

                    var div = document.createElement("div");
                    div.className = "w3-bar-item";
                    div.style.width = "100%";
                    //div.onclick = function(){load_lyrics(music.artist_name);};
                    //div.onclick = "load_lyrics('"+music.music_id+","+music.artist_id+","+music.music_title+","+music.artist_name+"')";
                   
                    var span_title = document.createElement("span");
                    span_title.style.color = "#34568b";
                    span_title.className = "w3-large w3-wide";
                    span_title.innerHTML = music.music_title;
                    span_title.setAttribute("onclick", "load_lyrics('musics_view','"+music.music_id+"','"+music.artist_id+"','"+music.music_title+"','"+music.artist_name+"');");

                    var span_artist = document.createElement("span");
                    span_artist.className = "w3-text-grey";
                    span_artist.innerHTML = music.artist_name;
                    
                    div.appendChild(span_title);
                    div.appendChild(document.createElement("br"));
                    div.appendChild(span_artist);
                    
                    // if session is 'admin' add remove buttons
                    if(isAdmin=='yes'){
                      var span_del = document.createElement('span');
                      span_del.className = "w3-text-red";
                      span_del.innerHTML = 'remove';
                      span_del.style.float = 'right';
                      span_del.setAttribute('onClick', "delete_music('"+music.music_id+"')");
                      div.appendChild(span_del);
                    }

                    li.appendChild(div);


                    ul.appendChild(li);

                  }
                  //console.log(musics[0]);
                  loadview("musics_view");

                });
}

/*
@params:-
onclick : the function to call when the list item is clicked
view: the view to return to when backbotton is pressed 

return an <li> element constructed with the given data
*/
function build_list_element(onclick, view, music_id, artist_id, title, title2){
  var li = document.createElement("li");
  li.class = "w3-bar"

  var div = document.createElement("div");
  div.className = "w3-bar-item";
  div.style.width = "100%";

  if(onclick=='load_artist_detail'){
    div.setAttribute("onclick", "load_artist_detail('"+artist_id+"');");
  }else{
    div.setAttribute("onclick", ""+onclick+"('"+view+"','"+music_id+"','"+artist_id+"','"+title+"','"+title2+"');");
  }
  
  var span_title = document.createElement("span");
  span_title.style.color = "#34568b";
  span_title.className = "w3-large w3-wide";
  span_title.innerHTML = title;

  var span_artist = document.createElement("span");
  span_artist.className = "w3-text-grey";
  span_artist.innerHTML = title2;

  div.appendChild(span_title);
  div.appendChild(document.createElement("br"));
  div.appendChild(span_artist);
  li.appendChild(div);

  return li;
}

function search(query){
  $.post('/search', {query:query},
        function(data){
          var res = JSON.parse(data);
          console.log(res);

          var artists = res.artist;
          var musics = res.musics;

          var ul = document.getElementById("ul_result_list");
          ul.innerHTML = "";

          for(var i=0;i<artists.length;i++){
            // build <li> elements for each artist
            var artist = artists[i];
            var li = build_list_element('load_artist_detail', 'search_result_view', '', artist.id, artist.artist_name, 'artist');
            ul.appendChild(li);
          }

          for(var i=0;i<musics.length;i++){
            // build <li> elements for each artist
            var music = musics[i];
            var li = build_list_element('load_lyrics', 'search_result_view', music.music_id, music.artist_id, music.music_title, 'music');
            ul.appendChild(li);
          }
          
          loadview('search_result_view');
        });
}

function is_admin(){
  // asks the server if the current session is set as admin
  $.post('/is_admin',{},
      function(data){
        return data;
      });
}


$(window).on('popstate', function(event) {
  var url = window.location.href;
  if(url.search('#').toString()=='-1'){

    if(on_back.length==1){
      var previous_view = on_back.pop();
      loadview(previous_view); // pop returns last element('the previous view') and deletes it from the array
    }else if(on_back.length==2){
      var previous_view = on_back.pop();
      loadview(previous_view);
      window.history.forward();
    } 
  }
  console.log(on_back);
  //alert(window.location.href);
});

// on page load.
$(document).ready(function (e) {
  loadview("home");
  var query1 = document.getElementById("search");

  /*
   attach on 'enter key pressed' action listener on the search input fields
   then onActionPerformed call search() function with the input value.
   */
  query1.addEventListener("keypress", function(event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
      search(query1.value);
    }
  });

  var query2 = document.getElementById("search2");

  query2.addEventListener("keypress", function(event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
      search(query2.value);
    } 
  });


   init_element_size(); // resize elements based on the screen size.
   
});

window.addEventListener('resize', function(event){
    init_element_size();
});

</script>

</body>


</html>
