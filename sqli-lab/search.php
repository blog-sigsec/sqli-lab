<?php

function search($username)
{
    require_once('config.php');
    $message = "";

	# On verifie que l'entree utilisateur soit correcte, sinon on affiche une erreur.
    if ($username !== "" && !empty($username)) {

        $user = trim($username);

        # On prepare notre requete SQL, le '?' sera remplace par l'entree utilisateur
        $query = "SELECT username FROM Users WHERE username = ?";
        if ($req = mysqli_prepare($db, $query)) {

            # C'est ici que l'on va prevenir les injections.
            # On lie les parametres fournis par l'utilisateur
            # a la requete qui sera envoyee au serveur.
            mysqli_stmt_bind_param($req, "s", $user);
            mysqli_stmt_execute($req);
            mysqli_stmt_store_result($req);

            # On verifie si SLQ nous retourne un resultat
            $num = mysqli_stmt_num_rows($req);
            if ($num === 0) {
                # Dans ce cas, aucun resultat.
                $message = "Unknow user.";
            }
            else if ($num === 1) {
                # Ici SQL nous renvoie un nom d'utilisateur.
                # On recupere le resultat dans la variable 'db_user'
                mysqli_stmt_bind_result($req, $db_user);
                mysqli_stmt_fetch($req);

                # Puis on renvoie le resultat, on libere la memoire, et on ferme la requete.
                $message = "User " . $db_user . " exist !";
                mysqli_stmt_free_result($req);
                mysqli_stmt_close($req);
            }
            else {
				# Dans ce cas, il y'a plusieurs resultats, ce qui n'est normalement pas possible.
				# On renvoie donc une erreur.
                $message = "Unknow error. Try again later.";
            }
        }
        else {
            $message = "Unknow error. Try again later.";
        }
    }
    else {
        $message = "Please fill the username input.";
    }
    return $message;
}
?>

<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>

  <body>
    <header>
      <nav id="navigation">
	<ul class="navigation">
	  <a class="navigation" href="index.php">Home</a>
	  <a class="navigation" href="create.php">create</a>
	  <a class="navigation" href="login.php">login</a>
	  <a class="navigation" href="search.php">Search</a>
	</ul>
      </nav>
    </header>
        </br>
        </br>
        </br>
	<div>
	 <form id="search" method="post" action="" accept-charset='UTF-8'>
	   <table align="center">
	     <tr>
	       <td>
		 <input type="text" name="username" placeholder="username"></td>
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
                  echo search($_POST['username']);
              }
      ?>
    </div>
  </body>
</html>
