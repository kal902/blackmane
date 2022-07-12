<html lang="en">
<title>Blackmane</title>
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

<!-- Sidebar/menu -->
<nav class="side w3-sidebar w3-metro-darken w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:250px;font-weight:bold;" id="mySidebar">
    <br>

    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">☰</a>

    <br><br>

    <div id='search_container' class='w3-panel'>
      <input id='search' style='width:200px;border:0px' class=" w3-hide-large w3-input w3-metro-darken" type="text" placeholder="search...">
    </div>

    <br>

    <a href="#home" onclick="loadview('home')"><img src="res/home2.png" alt="doctor" width="33" height="33"><i class="fa fa-fw"></i> Home</a>
    <a href="#artists" onclick="load_artists()"><img src="res/artist.png" alt="doctor" width="30" height="30"><i class="fa fa-fw"></i> Artists</a>
    <a href="#add_artist" onclick="loadview('addartist_view')"><i class="fa fa-fw"></i> Add Artists</a>
    <a href="#musics" onclick="load_musics(1)"><i class="fa fa-fw"></i> Musics</a>
    <a href="#add_music" onclick="loadview('addmusic_view')"><i class="fa fa-fw"></i> Add Music</a>

    <br><br><br>
    <form method='post' action='/log_out'>
      <button type='submit' class="w3-button w3-small">log out</button>
    </form>
    

</nav>

<?php include_once 'header.php'; ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main w3-dark" style="margin-left:260px;margin-right:10px">
	
  

  <?php
    include_once 'form_views.php';
    include_once 'artists_view.php';
    include_once 'musics_view.php';
    include_once 'detail_view.php';
    include_once 'lyrics_view.php';
    include_once 'home.php'
  ?>

  <div class="view" id="home"></div>


<!-- End page content -->
</div>


<script type="text/javascript" src="../lib/jquery.min.js"></script>
<script>

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

function add_music(){
  var artist_name = document.getElementById('artist_name2').value;
  var music_title = document.getElementById('music_title').value;
  var lyrics = document.getElementById('lyrics2').value;

  var msg = ''; // error message that will be returned
  var status = 1; // 1 = ok

  if(artist_name.length==0){
    msg += '\nplease enter a valid artist name,';
    //alert('please enter a valid artist name');
    status = 0;
  }
  if(music_title.length==0){
    msg += '\nplease enter a valid artist name,';
    //alert('please enter a valid artist name');
    status = 0;
  }
  if(lyrics.length==0){
    msg += '\nplease enter the lyrics,';
    //alert('please enter the lyrics');
    status = 0;
  }
  if(status==0){ // then form was not completed
    alert(msg);
    return;
  }

  $.post('/add_music',

                {artist_name:artist_name,
                 music_title:music_title,
                 lyrics:lyrics},

                function(data){
                    var json_res = JSON.parse(data);
                    var status = json_res.status;
                    if(status==1){ // successful
                      alert('music added');
                      /* clear the input fields and load the form view.
                         clearing the vars 'artist_name'... will not clear the actual input field on the view.
                      */
                      document.getElementById('artist_name2').value = "";
                      document.getElementById('music_title').value = "";
                      document.getElementById('lyrics2').value = "";
                      loadview('addmusic_view');
                    }else{
                      alert(json_res.msg);
                    }
                });

}

function load_lyrics(onback, musicid, artistid, musictitle, artistname){
  // first parameter is name of the view to show when backbutton is pressed.
  $.post('/lyrics',
           {music_id:musicid},

           function(data){
            var res = JSON.parse(data);
            document.getElementById('lyrics').innerHTML = res.lyrics;

            loadview('lyrics_view');
           });    
}

function load_musics(page){
  $.post('/musics',

                {page:page},

                function(data){
                  var musics = JSON.parse(data);
                  var ul = document.getElementById("ul_music_list");
                  ul.innerHTML = "";
                  for(var i=0;i<musics.length;i++){
                    var music = musics[i];

                    var li = document.createElement("li");
                    li.class = "w3-bar"

                    var div = document.createElement("div");
                    div.className = "w3-bar-item";
                    div.style.width = "100%";
                    //div.onclick = function(){load_lyrics(music.artist_name);};
                    //div.onclick = "load_lyrics('"+music.music_id+","+music.artist_id+","+music.music_title+","+music.artist_name+"')";
                    div.setAttribute("onclick", "load_lyrics('musics_view','"+music.music_id+"','"+music.artist_id+"','"+music.music_title+"','"+music.artist_name+"');");
                    var span_title = document.createElement("span");
                    span_title.style.color = "#34568b";
                    span_title.className = "w3-large w3-wide";
                    span_title.innerHTML = music.music_title;

                    var span_artist = document.createElement("span");
                    span_artist.className = "w3-text-grey";
                    span_artist.innerHTML = music.artist_name;

                    div.appendChild(span_title);
                    div.appendChild(document.createElement("br"));
                    div.appendChild(span_artist);
                    li.appendChild(div);


                    ul.appendChild(li);

                  }
                  //console.log(musics[0]);
                  loadview("musics_view");

                });
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
                        span_artistName.style.color = "#34568b";
                        span_artistName.innerHTML = artist.artist_name;
                        var div = document.createElement('div');
                        div.className = 'w3-container';
                        div.appendChild(span_artistName);

                        // container for holding image and details
                        var div2 = document.createElement('div');
                        div2.className = 'w3-metro-darken';
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
                    loadview("artists_view");

                });
  }
}

function load_artist_detail(id){
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

function delete_music(music_id){
    $.post('/delete_music',{id:music_id},
          function(data){
            var res = JSON.parse(data);
            if(res.status==0){
              alert('music successfuly deleted.');
            }else{
              alert('there was an error while deleting the music');
            }
          });

}

function delete_artist(artist_id){
    $.post('/delete_artist',{id:artist},
          function(data){
            var res = JSON.parse(data);
            if(res.status==0){
              alert('artist successfuly deleted.');
            }else{
              alert('there was an error while deleting the artist');
            }
          });
}
// ajax funtion to handle image upload form submition 
// without loading the page

// todo: result should be an html element containing the uploaded image so that the preview could be displayed
$(document).ready(function (e) {
   $("#add_artist_form").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
           url: "/add_artist",
         type: "POST",
         data:  new FormData(this),
         contentType: false,
               cache: false,
         processData: false,
         beforeSend : function()
         {
            //loadview("loader");
            //$("#preview").fadeOut();
            //$("#err").fadeOut();
            //alert("uploading");
         },
         success: function(data)
            {
              if(data=='invalid')
              {
               // invalid file format.
               //$("#err").html("Invalid File !").fadeIn();
              }
              else
              {
                alert(data);
               // view uploaded file.
               //$("#preview").html(data).fadeIn();
               //$("#form")[0].reset(); 
              }
            },
           error: function(e) 
            {
            //$("#err").html(e).fadeIn();
            }          
        });
     }
   ));

   //("#")
});

$(document).ready(function (e) {
  loadview("home");
  init_element_size(); // resize elements based on the screen size.
   
});

window.addEventListener('resize', function(event){
    init_element_size();
});
</script>

</body>


</html>
