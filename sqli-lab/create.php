<?php

# Process user post request
function create($user, $pass, $confirm) {

    $message = "";
    require_once('config.php');

    if (mysqli_connect_errno()) {
        $message = "Connexion échouée :" . mysqli_connect_error();
        exit();
    }

    if ($user !== "" && $pass !== "")
    {
        # First, check if username is available
        $query = "SELECT username FROM Users WHERE username='" . $user . "'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
            return "Username already taken :(";
        }
        $pass = trim($pass);
        $confirm = trim($confirm);

        # Password check
        if ($pass !== $confirm) {
            return "Passwords doesn't match, try again please.";
        }

        # Never store a plaintext password, so let's use a hash instead

        # LEVEL 1
        $hash = hash('sha256', $pass, false);
        $query = "INSERT INTO Users (username, password) VALUES ('" . $user . "', '" . $hash . "');";
        $result = mysqli_query($db, $query);
        var_dump($result);
        if ($result) {
            $message = "Account created :) You can now login as " . $user . " !";
            header("location: login.php");
        }
        else {
            $message = "Uknow error, try again leater please.";
        }

    }
    mysqli_close($db);
    return $message;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>

  <?php
   include("header.php");
  ?>

  </br>
  </br>
  </br>

  <body>
    <div>
      <form id="login" method="post" action="" >
	<table border="0" cellpadding="5"  align="center">
	  <tr>
	    <td>
	      <input type="text" name="username" placeholder="username">
	    </td>
	  </tr>
	  <tr>
	    <td>
	      <input type="password" name="password" placeholder="password">
	    </td>
	  </tr>
	  <tr>
	    <td>
	      <input type="password" name="confirmation" placeholder="confirmation">
	    </td>
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
         echo create( $_POST['username'], $_POST['password'], $_POST['confirmation'] );
     }
     ?>
    </div>
  </body>

  <footer class="foot">
      Contact us at admin@sqli-lab.com!
  </footer>
</html>
