<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/privatePics.css">
</head>

<?php
include_once("header.php");
?>

<body>
    <h1 class="title is-4"> Edite et partage </h1>
    <main>
        <div class = container >
            <?php 
                $id = $_GET['id'];
                include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
                $sql = $db->prepare("SELECT id_image FROM images WHERE id_image = $id");
                $sql->execute();
                $resultId = $sql->fetch();
                if($resultId) {
                $boolean = 0;
                $sql = $db->prepare("SELECT dir FROM images WHERE id_image = $id");
                $sql->execute();
                $resultPath = $sql->fetch();
                $path = $resultPath['dir'];
                if(isset($path)){
                echo '<div>';
                    echo '<img class="commentImage" src=' . $path . ' width="500px" height="375px"/>';
                echo '</div>';
                }
                else {
                echo '<div>';
                    echo '<p> Image non disponible </p>';
                echo '</div>';
                }
                echo '<div class="imageLike">';
                
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==TRUE) {
                    $user = $_SESSION['user'];
				    $sql = $db->prepare("SELECT likes FROM likes WHERE id_image = $id AND username_like = '".$user."'");
				    $sql->execute();
				    $likesUsers = $sql->fetch();
                    $boolean = $likesUsers['likes'];
                
			    echo '</br>
                    
			    <form id="form_like_suppress" method="POST" action="backend/storelike_back.php">
			        <button class="center btn button" name="click_like" style="width: 90px; border-radius: 2px;">
			    	<input type="hidden" name="username" value="'.$user.'">
			    	<input type="hidden" name="picture" value="'.$path.'">
			    	<input type="hidden" name="pict_id" value="'.$id.'">';
                    
                    
			        if ($boolean == 1)
			        	echo '<i class="fa-heart fas" style="color: red;"></i>';
			        else if ($boolean == 0)
			        	echo '<i class="fa-heart far" style="color: black;"></i>';
                    echo '</button>
                </form>';
                }
                           
                echo '</div>';
                        
                        echo '<div class="imageTitle">';
                            $sql = $db->prepare("SELECT user, titleImage FROM images WHERE id_image=$id");
                            $sql->execute();
                            $image = $sql->fetch();
                            $titleWriter = $image['user'];
                            $titleImage = $image['titleImage'];
                            echo $titleWriter . ': '. $titleImage;
                            $sql = $db->prepare("SELECT nb_like FROM images WHERE id_image = $id");
                            $sql->execute();
                            $nbLike = $sql->fetch();
                            $nbLike = $nbLike['nb_like'];
                            echo "<p> Aimé par ".$nbLike." personnes </p>";
                        echo '</div> </br>';
                        
                        $sql = $db->prepare("SELECT comment, username FROM commentaires WHERE id_image=$id ORDER BY id_comments ASC");
                        $sql->execute();
                        $all_comments = $sql->fetchall();
                        foreach($all_comments as $comment) {
                            $com = $comment['comment'];
                            $writer = $comment['username'];
                            echo '<div class="comments">';
                               echo $writer . ': '. $com;
                            echo '</div>';
                        } 
                    echo '</div>';
                }
                else {
                    header("Location: ../index.php");
                }
            ?>
            </br>
            <form name="commentaire" method="post" action="backend/comment_back.php">
                <div class="field">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE): ?>
                        <label class="label">Commente la photo</label>
                        <div class="control has-icons-left has-icons-right">
                            <input type="hidden" name="idImage" value="<?php echo htmlspecialchars($id); ?>">
                            <input class="input" type="text" name="commentaire" placeholder="ecrivez un commentaire">
                        <?php else: ?>
                            <p> Vous devez vous connecter pour commenter et liker les photos </p>
                        <?php endif ?>
                    </div>
                </div>
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE): ?>
                    <div class="field">

                        <input type="submit" name="commentPic" value="Publier" class="button is-success">
                    </div>
                <?php endif ?>
            </form>
        </div>
    </main>
</body>
<?php
include_once("footer.php");
?>
</html>