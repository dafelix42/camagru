<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/forms.css">
</head>

<?php
include("header.php");
?>
<body>
  <h1 class="title is-4"> Connexion </h1>
  <form name="connexion" method="post" action="backend/connexion_back.php">
    <div class="field">
      <label class="label">Nom d'utilisateur</label>
      <div class="control has-icons-left has-icons-right">
        <input class="input" type="text" name="login" placeholder="Votre login">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
        <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
      </div>
    </div>

    <div class="field">
      <label class="label">Mot de passe</label>
      <p class="control has-icons-left">
        <input class="input" type="password" name="passwd" placeholder="Votre mot de passe">
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div>

    <div class="field">
      <p class="control">
        <input type="submit" name="connexion_submit" value="OK" class="button is-success">        
      </p>
    </div>
    <?php if(isset($_GET['connexion']) && $_GET['connexion'] == "error"): ?>
      <span class="help is-danger">Il y a une erreur dans votre login ou votre mot de passe</span>
    <?php endif ?>
    <?php if(isset($_GET['field']) && $_GET['field'] == "error"): ?>
      <span class="help is-danger">Tous les champs ne sont pas renseignés</span>
    <?php endif ?>
    <?php if(isset($_GET['confirmation']) && $_GET['confirmation'] == "error"): ?>
      <span class="help is-danger">Vous n'avez pas encore confirmer votre email</span>
    <?php endif ?>
  </form>
  <div class="field">
    <a href="resetPasswd.php"> Mot de passe oublié?</a>
  </div>
</body>
<?php
include_once("footer.php");
?>
</html>