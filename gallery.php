<?php
          include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
          $imagesParPage = 6;
          $sql = $db->prepare("SELECT COUNT(id_image) FROM images");
          $sql->execute();
          $imageTotales = $sql->fetch();
          $imageTotales = $imageTotales['COUNT(id_image)'];
          $pagesTotales = ceil($imageTotales/$imagesParPage);
          if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
            $_GET['page'] = intval($_GET['page']);
            $pageCourante = $_GET['page'];
         } else {
            $pageCourante = 1;
         }
         $depart = ($pageCourante-1)*$imagesParPage;
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/gallery.css">
</head>

<?php
include_once("header.php");
?>
<body>
  <main>
    <section class="galleryLinks">
      <div class="gallery">
        <h1> Galerie </h1>
        <div class="galleryContainer">
          <?php
          $sql = $db->prepare('SELECT * FROM images ORDER BY id_image DESC LIMIT '.$depart.','.$imagesParPage);
          $sql->execute();
          $images = $sql->fetchall();
          foreach($images as $img) {
            $idImage = $img['id_image'];
            $src = $img['dir'];
            $owner = $img['user'];
            $title = $img['titleImage'];
            echo
            '<a href=commentLike.php?id='.$idImage.'>
			    	  <div class="imagePublic">
			    	    <img src='.$src.' width="300px"/>
                <p>'.$owner.': '.$title.'<p>
                </br>
              </div>
			    	</a>';
          }
          
          ?>
        </div>
        <?php
        for($i=1;$i<=$pagesTotales;$i++) {
            if($i == $pageCourante) {
               echo $i.' ';
            } else {
               echo '<a href="index.php?page='.$i.'">'.$i.'</a> ';
            }
          }
        ?>
      </div>
    </section>
  </main>

  <script>
  function submitform()
  {
  document.getElementById("imagesProperties").submit();
  }
  </script>

</body>
<?php
include_once("footer.php");
?>
</html>