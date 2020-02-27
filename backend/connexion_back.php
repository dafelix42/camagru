<?php
if(!isset($_SESSION))
{
    session_start();
}
    $valid = "";
    
    $_SESSION["logged_in"] = FALSE;
    if (isset($_POST['connexion_submit']))
    {
        $username = htmlspecialchars(trim($_POST["login"]));
        $password = htmlspecialchars($_POST["passwd"]);
        if (!empty($username) && !empty($password) && $_POST["connexion_submit"] == "OK")
        {
            include("$_SERVER[DOCUMENT_ROOT]/config/setup.php");
            $sql = $db->prepare('SELECT username, passwd, confirmation FROM utilisateurs');
            $sql->execute();
            $user_infos = $sql->fetchall();
            foreach($user_infos as $user) {
                if ($user['username'] == $username && password_verify($password, $user['passwd']) && $user['confirmation'] == 0) {
                    $err_confirmation = "error";
                    header("Location:../connexion.php?login=$username&confirmation=$err_confirmation");
                }
                else if ($user['username'] == $username && password_verify($password, $user['passwd']) && $user['confirmation'] == 1) {
                        $_SESSION["logged_in"] = TRUE;
                        $_SESSION["user"] = $username;
                        header("location:../gallery.php");
                        exit();
                }
            };
            if (!isset($err_confirmation)) {
                $err_connexion = "error";
                header("Location:../connexion.php?login=$username&connexion=$err_connexion");
                exit();
            }
        }
        else {
            $err_field = "error";
            header("Location:../connexion.php?login=$username&field=$err_field");
            exit();
        }
    }
    else {
        header("Location:../index.php");
    }
?>