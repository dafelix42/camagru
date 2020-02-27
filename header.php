<?php
include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
if(!isset($_SESSION))
{
	session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/css_font_awesome/all.css">
    <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
    
</head>

<body>
    <header>
        <div class="nav">
            <div id="main">
                <h1 class="title is-1">
                    <a href="/index.php" class="navbar-item">
                        Camagru
                    </a>
                </h1>
            </div>
            <!-- <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a> -->
            <div id="nabar">
                <?php
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE){
                    echo "<a href=\"/ui.php\" class=\"button is-primary\")>
                        <strong>Mon espace</strong>
                    </a>";
                    echo "<a href=\"/parametres.php\" class=\"button is-dark\">
                        Paramètres
                    </a>";
                    echo "<a href=\"/backend/logout.php\" class=\"button is-light\">
                        Deconnexion
                    </a>";
                }
                else {
                    echo "<a href=\"/inscription.php\" class=\"button is-primary\">
                    <strong>Inscription</strong>
                    </a>";
                    echo "<a href=\"/connexion.php\" class=\"button is-light\">
                        Connexion
                    </a>";
                }
                ?>
            </div>
        </div>
    </header>
</body>

</html>