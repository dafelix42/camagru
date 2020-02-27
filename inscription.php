<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/forms.css">
</head>

<?php
include("header.php");
?>
<body>
  <h1 class="title is-4"> Inscription </h1>
  <?php if(!isset($_GET['autor']) || $_GET['autor'] !== "success"): ?> 
  <form name="inscritpion" method="post" action="backend/inscription_back.php">
    <div class="field">
      <label class="label">Nom d'utilisateur</label>
      <div class="control has-icons-left has-icons-right">
        <input class="input" type="text" name="login" placeholder="Nom d'utilisateur">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
        <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
      </div>
      <?php if(isset($_GET['namelen']) && $_GET['namelen'] == "error"): ?>
        <span class="help is-danger">Votre nom d'utilisateur doit être compris entre 3 et 20 caractères</span>
      <?php endif ?>
      <?php if(isset($_GET['name']) && $_GET['name'] == "error"): ?>
        <span class="help is-danger">Votre nom doit contenir uniquement des chiffres et des lettres</span>
      <?php endif ?>
      <?php if(isset($_GET['logDispo']) && $_GET['logDispo'] == "error"): ?>
        <span class="help is-danger">Login non disponible</span>
      <?php endif ?>
    </div>
  
    <div class="field">
      <label class="label">E-mail</label>
      <div class="control has-icons-left has-icons-right">
        <input class="input" type="email" name="email" placeholder="Votre e-mail">
        <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
        <span class="icon is-small is-right">
          <i class="fas fa-exclamation-triangle"></i>
        </span>
      </div>
      <?php if(isset($_GET['mail']) && $_GET['mail'] == "error"): ?>
        <span class="help is-danger">Adresse e-mail au mauvais format</span>
      <?php endif ?>
      <?php if(isset($_GET['mailDispo']) && $_GET['mailDispo'] == "error"): ?>
        <span class="help is-danger">Adresse email déjà utilisée</span>
      <?php endif ?>
      
    </div>
  
    <div class="field">
      <label class="label">Mot de passe</label>
      <p class="control has-icons-left">
        <input class="input" type="password" name="passwd"placeholder="Votre mot de passe">
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div>
    <?php if(isset($_GET['pass']) && $_GET['pass'] == "error"): ?>
      <span class="help is-danger">Votre mot de passe doit avoir au minimum 8 caractères, au moins une majuscule, une minuscule, un chiffre et un caractère spécial, sans espace</span>
    <?php endif ?>
  
    <div class="field">
      <label class="label"> Confirmer votre mot de passe</label>
      <p class="control has-icons-left">
        <input class="input" type="password" name="confirmPasswd" placeholder="Confirmez votre mot de passe">
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div>
    <?php if(isset($_GET['conf']) && $_GET['conf'] == "error"): ?>
      <span class="help is-danger">Erreur confirmation de mot de passe</span>
    <?php endif ?>

    <div class="field">
      <p class="control">
        <input type="submit" name="inscription_submit" value="Valider" class="button is-success">
      </p>
    </div>
    <?php if(isset($_GET['field']) && $_GET['field'] == "error"): ?>
      <span class="help is-danger">Tous les champs ne sont pas renseignés</span>
    <?php endif ?>
  </form>
  <?php else: ?>
    <p> Nous vous avons envoyé un e-mail avec un lien confirmation.<br>
    Une fois validé vous aurez accès à votre espace personnel et vous pourrez commenter et liker les photos.</p>
    <p> A bientôt ;-)! </p>
  <?php endif ?>
</body>
<?php
include_once("footer.php");
?>
</html>