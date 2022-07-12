<title>BLACKMANE</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="../css/w3-colors-metro.css">
<style>
	body{background:black;}
</style>
<body>
	<header class="w3-container w3-top w3-metro-darken w3-xlarge w3-padding">
 	 <span style="color:#FFD700" class="w3-wide w3-center">Blackmane</span>
	</header>

	<div style='margin-top: 25%' class='w3-container w3-center'>
	  <div id="id01">
	    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

	      <form class="w3-container" action="/auth" method='post'>
	        <div class="w3-section">
	          <label><b>Username</b></label>
	          <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="user_name" required>
	          <label><b>Password</b></label>
	          <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="passwd" required>
	          <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
	          
	        </div>
	      </form>

	    </div>
	  </div>
	</div>
<?php
	if($msg!==false){
		echo "<script>alert('".$msg."');</script>";
	}
?>
</body>