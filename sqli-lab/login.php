<?php


function login($username, $password)
{
    require_once('config.php');
    $message = "";

    if ($username !== "" && $password !== "")
    {
        $query = "SELECT username, password FROM Users WHERE username = ?";
        if ($req = mysqli_prepare($db, $query)) {

            # C'est ici que l'on va prevenir les injections.
            # On lie les parametres fournis par l'utilisateur
            # a la requete qui sera envoyee au serveur.
            mysqli_stmt_bind_param($req, "s", $user);
            mysqli_stmt_execute($req);
            mysqli_stmt_store_result($req);

            # On verifie le resultat
            $num = mysqli_stmt_num_rows($req);
            if ($num === 0) {
                $message = "Provided credentials are wrong";
            }
            else if ($num === 1) {

                # On lie le retour dans des variables
                mysqli_stmt_bind_result($req, $db_user, $db_hash);
                # On recupere les resultats
                mysqli_stmt_fetch($req);
                if (password_verify($pass, $db_hash) === true) {
                    $message = "You are now connected as $db_user";
                }
                # liberation de la memoire
                mysqli_stmt_free_result($req);
                mysqli_stmt_close($req);
            }
            else
            {
                $message = "Uknow error. Try again later. [1]";
            }
        }
        else
        {
            $message = "Uknow error. Try again later. [2]";
        }
    }
    return $message;
}
?>

<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>
  <?php
   include("header.php");
   ?>
  <body>
  </br>
  </br>
  </br>
  <div>
    <form id="login" method="post" action="">
      <table border="0" cellpadding="5"  align="center">
	<tr>
	  <td>
	    <input type="text" name="username" placeholder="username"></td>
	</tr>
	<tr>
	  <td>
	    <input type="password" name="password" placeholder="password"></td>
	</tr>
	<tr>
	  <td>
	    <input type="submit" name="submit" value="submit">
	  </td>
	</tr>
      </table>
    </form>
  </div>
  <div class="message">
    <?php
     if ($_POST['submit']) {
       echo login($_POST['username'], $_POST['password']);
     }
     ?>
  </div>
  </body>
  <?php
   include("footer.php");
   ?>
</html>
