

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/ui.css">
</head>

<?php
include_once("header.php");
if($_SESSION["logged_in"] == FALSE) {
  header("Location:connexion.php");
}
?>
<body>
  <h1 class="title is-4"> Mon espace </h1>

  
  <main>
    <div class="columnLeft">
      	<form id="photoMontage" method="POST" action="backend/storechoosefile_back.php" enctype="multipart/form-data">
        	<div>
				<div style="position: relative;">
					<p>Vous devez choisir un filtre pour prendre une photo</p>
        			<div id=filterAboveCam style="position: absolute;"><img id="imgAboveCam" style="margin-top: 0px; margin-left: 0px;" src=""></div>
        			<div id="my_camera"></div>
					<br/>
					<input id="choose_file" name="photo" type="file" onchange="upload_check();loadFile(event);" >
					<?php if(isset($_GET['size']) && $_GET['size'] == "error"): ?>
        				<span class="help is-danger">Votre fichier est trop gros</span>
        			<?php elseif(isset($_GET['import']) && $_GET['import'] == "error"): ?>
        				<span class="help is-danger">Il y a eu une erreur lors de l'importation du fichier</span>
        			<?php elseif(isset($_GET['type']) && $_GET['type'] == "error"): ?>
        				<span class="help is-danger">Vous ne pouvez pas importer un fichier de ce type</span>
        			<?php endif ?>
        		  	<input id="button_snap" type="button" value="Prendre une photo" onClick="takePicture()" class="button btn_snap" style="display:none;">
        		  	<input type="hidden" name="image" class="image-tag" id="picture" value="var-tag">
        		</div>
        		<div style="position: relative;">
					<div id="filterAboveSnap" style="position: absolute;">
						<img id="imgAboveSnap" style="margin-top: 5px; margin-left: 5px;" src="">
					</div>
  					<div id="results" style="margin-top: 0px;"></div>
        		  	<input type="hidden" id="filter" name="filter" value="">
					<input type="hidden" id="filter_screen" name="filter_screen" value="">
					<div class="field">
                    	<div class="control has-icons-left has-icons-right">
                        	<input id="title" class="input" type="text" name="titrePhoto" placeholder="inserer ici un titre et une description de votre photo" style="display: none">
                    	</div>
                	</div>
        		  	<button id="submit" name="saveMontage" class="btn button" style="display: none">Sauver et partager la photo</button>
				</div>
			</div>
      	</form>


		<p> Selectionne un filtre </p>
        <div class="masks-container" >
        	<div>
				<img class="mask" src="./filter/davfelix.png" onclick="selectFilter('davfelix')" title="davfelix">
			    <img class="mask" src="./filter/chat.png" onclick="selectFilter('chat')" title="chat">
			    <img class="mask" src="./filter/moustache.png" onclick="selectFilter('moustache')" title="moustache">
          	</div>
        </div>
		<p> Supprimer le filtre </p>
		<img class="delete" src="./filter/close.gif" onclick="selectFilter('cancel')" title="cancel">
	</div>
	
	<div class="columnRight" style="margin-right: 50px;">
		<div class="myPics" >
			<?php
			$owner = $_SESSION['user'];
			$sql = $db->prepare("SELECT dir, user FROM images");
    		$sql->execute();
			$user_images = $sql->fetchall();
			foreach($user_images as $user) {
				if ($user['user'] == $owner) {
					$src = $user['dir'];
					echo "<a href=backend/myPics_back.php?src=$src>";
					echo '<div class = imageOwner>';
					echo '<img src='.$src.' width="100px"/>';
					echo '<img src="css/poubelle.png" class="img-top" alt="delete the picture">';
					echo '</div>';
					echo '</a>';
				}
			}
			?>
		</div>
	</div>
</main>

  

  <script language="JavaScript">

  	var bool = 0;
	var accept = 1;

	function upload_check()
	{
    	var upl = document.getElementById("choose_file");

   		if(upl.files[0].size > 2000000)
    	{
			accept = 0;
       		alert("Le fichier est trop gros!");
       		upl.value = "";
			document.location.reload(true);
    	}
		else if(upl.files[0].size < 10000)
    	{
			accept = 0;
       		alert("Le fichier est trop petit!");
       		upl.value = "";
			document.location.reload(true);
    	}
	};

    function loadFile(event){
		if (accept === 0)
			return;
		if (event === null || event === undefined)
		{
			return false;
		}
		else
		{
			document.getElementById("photoMontage").action = "backend/storechoosefile_back.php";
			document.getElementById("imgAboveSnap").src = "";
			document.getElementById("filterAboveSnap").style.display = "none";
			if (document.getElementById('snappedOrUploaded')){
				document.getElementById('snappedOrUploaded').remove();
			}
			var img = document.createElement("img");
			img.setAttribute("id", "snappedOrUploaded");
			img.src = URL.createObjectURL(event.target.files[0]);
			var src = document.getElementById('results');
			src.appendChild(img);
			
			document.getElementById("snappedOrUploaded").style.minHeight = "375px";
			document.getElementById("snappedOrUploaded").style.maxHeight = "375px";
			document.getElementById("snappedOrUploaded").style.minWidth = "500px";
			document.getElementById("snappedOrUploaded").style.maxWidth = "500px";
		}
	}

    

    Webcam.set(
    {
    	width: 500,
    	height: 375,
    	image_format: 'png',
    	png_quality: 90
    });
  
    navigator.permissions.query({name: 'camera'})
    .then((value) =>
    {
      if (value.state == 'denied')
      {
        bool = 1;
        return;
      }
      else if (value.state == 'granted')
      {
        Webcam.attach( '#my_camera' );
      }
    }
  	);

  	function takePicture() {
     	 Webcam.snap(function(data_uri){
			$(".image-tag").val(data_uri);
			document.getElementById('results').innerHTML = '<img id="snappedOrUploaded" src="'+data_uri+'"/>';
		});
		document.getElementById("submit").style.display = "block";
		if (document.getElementById('filter').value == 'davfelix')
			document.getElementById('filter_screen').value = 'davfelix';
		if (document.getElementById('filter').value == 'moustache')
			document.getElementById('filter_screen').value = 'moustache';
		if (document.getElementById('filter').value == 'chat')
			document.getElementById('filter_screen').value = 'chat';

		if (document.getElementById("picture").value != "var-tag" && document.getElementById("filter").value == "davfelix"){
			document.getElementById("imgAboveSnap").src = "./filter/davfelix.png";
			document.getElementById("filterAboveSnap").style.display = "block";
		}
		else if (document.getElementsByClassName("picture").value != "var-tag" && document.getElementById("filter").value == "chat"){
      		document.getElementById("imgAboveSnap").src = "./filter/chat.png";
			document.getElementById("filterAboveSnap").style.display = "block";
		}
		else if (document.getElementsByClassName("picture").value != "var-tag" && document.getElementById("filter").value == "moustache"){
      document.getElementById("imgAboveSnap").src = "./filter/moustache.png";
			document.getElementById("filterAboveSnap").style.display = "block";
		}
		document.getElementById("photoMontage").action = "backend/storeImage_back.php";
    }


	function selectFilter(filter)
	{
		if (bool === 0)
		{
			if (filter === 'davfelix')
			{
				document.getElementById("imgAboveCam").src = "./filter/davfelix.png";
				document.getElementById('filterAboveCam').style.display = "block";
				document.getElementById("button_snap").style.display = "block";
				document.getElementById("title").style.display = "block";
				if (document.getElementById('snappedOrUploaded')) {
					document.getElementById("imgAboveSnap").src = "./filter/davfelix.png";
					document.getElementById('filterAboveSnap').style.display = "block";
					document.getElementById("button_snap").style.display = "block";
					document.getElementById("submit").style.display = "block";
					document.getElementById("title").style.display = "block";
				}
			}
			if (filter === 'chat')
			{
				document.getElementById("imgAboveCam").src = "./filter/chat.png";
				document.getElementById('filterAboveCam').style.display = "block";
				document.getElementById("button_snap").style.display = "block";
				document.getElementById("title").style.display = "block";
				if (document.getElementById('snappedOrUploaded')) {
					document.getElementById("imgAboveSnap").src = "./filter/chat.png";
					document.getElementById('filterAboveSnap').style.display = "block";
					document.getElementById("button_snap").style.display = "block";
					document.getElementById("submit").style.display = "block";
					document.getElementById("title").style.display = "block";
				}
			}
			if (filter === 'moustache')
			{
				document.getElementById("imgAboveCam").src = "./filter/moustache.png";
				document.getElementById('filterAboveCam').style.display = 'block';
				document.getElementById("button_snap").style.display = "block";
				document.getElementById("title").style.display = "block";
				if (document.getElementById('snappedOrUploaded')) {
					document.getElementById("imgAboveSnap").src = "./filter/moustache.png";
					document.getElementById('filterAboveSnap').style.display = "block";
					document.getElementById("button_snap").style.display = "block";
					document.getElementById("submit").style.display = "block";
					document.getElementById("title").style.display = "block";
				}
			}
			if (filter === 'cancel')
			{
				document.getElementById('snappedOrUploaded').remove();
				document.getElementById("imgAboveSnap").src= "";
				document.getElementById("filterAboveSnap").style.display= 'none';
				document.getElementById('filterAboveCam').style.display = 'none';
				document.getElementById('submit').style.display = 'none';
				document.getElementById("title").style.display = "none";
				document.getElementById("button_snap").style.display = "none";
			}
			document.getElementById("filter").value = filter;
		}
		if (bool == 1)
		{
			document.getElementById("filter").value = filter;
			document.getElementById('filter_screen').value = filter;
			document.getElementById("submit").style.display = "block";
			document.getElementById("title").style.display = "block";
		}
	}

  	</script>
</body>
<?php
include_once("footer.php");
?>
</html>