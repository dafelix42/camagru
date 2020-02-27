<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/forms.css">
</head>

<?php
include_once("header.php");
?>
<body>
  <h1 class="title is-4"> Changer le mot de passe </h1>
  <?php
  if(!isset($_GET["reset"])): ?>
  <p> Un email va vous être envoyé avec les instruction pour reinitialiser votre mot de passe.</p>
  <form method="post" action="backend/resetRequestPwd_back.php">
  <div class="field">
    <label class="label">E-mail</label>
    <div class="control has-icons-left has-icons-right">
      <input name="email" class="input" type="email" placeholder="Entrez votre e-mail">
      <span class="icon is-small is-left">
        <i class="fas fa-envelope"></i>
      </span>
      <span class="icon is-small is-right">
        <i class="fas fa-exclamation-triangle"></i>
      </span>
    </div>
      <?php if(isset($_GET["error"])): ?>
        <?php if($_GET["error"]=== 'err_field'): ?>
          <span class="help is-danger">Tous les champs ne sont pas renseignés</span>
        <?php else: ?>
          <span class="help is-danger">Adresse e-mail au mauvais format</span>
        <?php endif ?>
      <?php endif ?>
  </div>
  <div class="field">
    <p class="control">
      <button type="submit" name="resetRequestSubmit" value="Valider"class="button is-success">
        Envoyez moi un e-mail de réinitialisation
      </button>
    </p>
   
  </div>
  </form>
  <?php
  else: ?> 
      <p>Regardez vos email!</p>
  <?php endif ?>
</body>
<?php
include_once("footer.php");
?>
</html>