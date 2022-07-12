<!-- !ADD ARTIST VIEW! -->

  <div class="view" id="addartist_view" style="margin-top:100px">  
      <div style="margin-left: 10px;margin-right: 10px" class="w3-container w3-green">
            <h2>Add Artist</h2>
      </div>
      <form style="margin-left: 10px;margin-right: 10px" class="w3-container w3-card-4 w3-white" id="add_artist_form" method="post" enctype="multipart/form-data">
        <p><label>Select Image</label>
        <input type="file" name="image" id="image"></p>
        <p><label>Name</label>
        <input class="w3-input w3-border w3-round" type="text" name="artist_name" id="artist_name"></p>
        <p><label>Artist Detail</label>
        <input class="w3-input w3-border w3-round" type="text" name="artist_detail" id="artist_detail"></p>
        <p><label>Additional Info</label>
        <input class="w3-input w3-border w3-round" type="text" name="info" id="info"></p>
        <input class="w3-button w3-green w3-round-large" style="margin-bottom: 10px" type="submit" value="Add Artist" name="submit">
      </form>
  </div><!-- !End add Artist View! -->

  <!-- !Add Music View! -->
  <div class="view" id="addmusic_view" style="margin-top:100px">  
      <div style="margin-left: 10px;margin-right: 10px" class="w3-container w3-indigo">
            <h2>Add Music</h2>
      </div>
      <div style="height:75%;margin-left: 10px;margin-right: 10px" class="w3-container w3-card-4 w3-white" id="add_music_form">
        
        <p><label>Artist Name</label>
        <input class="w3-input w3-border w3-round" type="text" name="artist_name2" id="artist_name2" required></p>
        <p><label>Music Title</label>
        <input class="w3-input w3-border w3-round" type="text" name="music_title" id="music_title"></p>

        <button style="float:right;margin-top: 70%" onclick="loadview('edit_lyrics_view')" class="w3-button w3-margin-bottom w3-indigo">Next</button>
      </div>
  </div>
  <!-- !End add Music View! -->

  <div class="view" id="edit_lyrics_view" style="margin-top:100px">  

      <div style="margin-left: 10px;margin-right: 10px" class="w3-container w3-indigo">
            <h2>Enter Lyrics</h2>
      </div>

      <div style="height:80%;margin-left: 10px;margin-right: 10px" class="w3-container w3-card-4 w3-white" id="add_music_form">
        
        
        <textarea style="margin-top:20px;margin-left:10%;margin-right:10%;height:50%;width:80%;resize:none" id="lyrics2" class="w3-border w3-round w3-center"></textarea>

        
        <button style="float:right;margin-top: 40%" onclick="add_music()" class="w3-button w3-margin-bottom w3-indigo">Add Music</button>
        <button style="float:right;margin-top: 40%;margin-right: 10px" onclick="loadview('addmusic_view')" class="w3-button w3-margin-bottom w3-indigo">Back</button>

      </div>
  </div>