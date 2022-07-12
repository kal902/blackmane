<!-- Top menu on small screens --> 
<header class="topnav w3-hide-large w3-container w3-top w3-metro-darken w3-xlarge w3-padding"><!-- w3-hide-large to make header dissappear on large screen -->
  <a href="javascript:void(0)" class="w3-button w3-metro-darken w3-margin-right" onclick="w3_open()">☰</a>
  <span style="color:#FFD700" class="w3-wide w3-cursive">Blackmane</span>

</header>

<div id='header_big' style='margin-left:260px;margin-right: 5px;height:65px' class="w3-container w3-metro-darken w3-padding"><!-- w3-hide-large to make header dissappear on large screen -->
  <span style="color:#FFD700" class="w3-wide w3-xlarge w3-cursive">Blackmane</span>

  <div id='search_container2' style="float:right">
      <input id='search2' style='width:200px;border:0px' class=" w3-hide-small w3-input w3-metro-darken" type="text" placeholder="search...">
   </div>

   
</div>

	<div id='progress_bar' class="w3-top w3-border-grey" style='margin-right:10px;width:100%'>
  		<div id='progress' class="w3-red" style="height:3px;width:60%"></div>
   </div>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>