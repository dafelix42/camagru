<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/forms.css">
</head>

<?php
include("header.php");
?>
<body>
  <h1 class="title is-4"> Créer un nouveau mot de passe </h1>
  <?php
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if(empty($selector) || empty($validator))
      echo "Votre demande n'a pas pu être validée";
    else {
      if (ctype_xdigit($selector) !== FALSE && ctype_xdigit($validator) !== FALSE) {
        ?>
        <form action="backend/resetPasswd_back.php" method="post">
          <input class="input" type="hidden" name="selector" value="<?php echo $selector ?>">
          <input class="input" type="hidden" name="validator" value="<?php echo $validator ?>">
          <div class="field">
            <input class="input" type="password" name="pwd" placeholder="Entrer un nouveau mot de passe">
          </div>
          <div class="field">
            <input class="input" type="password" name="confirmPwd" placeholder="Confirmez votre mot de passe">
          </div>
          <?php if(isset($_GET["error"])): ?>
            <?php if($_GET["error"]=== 'err_empty'): ?>
              <span class="help is-danger">Tous les champs ne sont pas renseignés</span>
            <?php endif ?>
            <?php if($_GET["error"]=== 'err_confirm'): ?>
              <span class="help is-danger">Erreur dans la confirmation du mot de passe</span>
            <?php endif ?>
            <?php if($_GET["error"]=== 'err_length'): ?>
              <span class="help is-danger">Votre mot de passe doit être compris entre 8 et 32 caractères</span>
            <?php endif ?>
            <?php if($_GET["error"]=== 'err_token'): ?>
              <span class="help is-danger">Vous devez refaire une demande de mot de passe perdu</span>
            <?php endif ?>
          <?php endif ?>
          <div class="field">
            <button type="submit" name="resetPasswdSubmit" class="button is-success">Réinitialiser le mot de passe</button>
          </div>
        </form>
        <?php
      }
    }
  ?>
  <!-- <?php if(!$valid == TRUE): ?> 
  <form name="changePwd" method="post" action="changePwd.php">
    <div class="field">
      <label class="label">Nouveau mot de passe</label>
      <p class="control has-icons-left">
        <input class="input" type="password" name="newPasswd"placeholder="Votre nouveau mot de passe">
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div>
     -->
    <?php if(isset($err_pass)): ?>
      <span class="help is-danger"><?php echo $err_pass ?></span>
    <?php endif ?>
  
    <!-- <div class="field">
      <label class="label"> Confirmer votre mot de passe</label>
      <p class="control has-icons-left">
        <input class="input" type="password" name="confirmPasswd" placeholder="Confirmez votre mot de passe">
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div> -->
    <?php if(isset($err_conf)): ?>
      <span class="help is-danger"><?php echo $err_conf ?></span>
    <?php endif ?>

    <!-- <div class="field">
      <p class="control">
        <input type="submit" name="changePass" value="Valider" class="button is-success">
      </p>
    </div> -->
    <?php if(isset($err_field)): ?>
      <span class="help is-danger"><?php echo $err_field ?></span>
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