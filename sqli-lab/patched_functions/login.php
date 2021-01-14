<?php

function login($username, $password)
{
    require_once('config.php');
    $message = "";

    $user = trim($username);
    $pass = trim($password);

    if ($username === "" || $password === "") {
        $message = "Please fill username and password.";
        mysqli_close($db);
        return $message;
    }

    $query = "SELECT username, password FROM Users WHERE username = ?";
    if (($req = mysqli_prepare($db, $query)) === false) {
        $message = "Uknow error, try again later.";
        mysqli_close($sb);
        return $message;
    }
    mysqli_stmt_bind_param($req, "s", $user);
    mysqli_stmt_execute($req);
    mysqli_stmt_store_result($req);
    $num = mysqli_stmt_num_rows($req);
    if ($num === 1) {
        mysqli_stmt_bind_result($req, $db_user, $hash);
        mysqli_stmt_fetch($req);
        if ($user === $db_user && password_verify($pass, $hash)) {
            $message = "Logged as " . $db_user . " !";
        }
        else {
            $message = "Provided credentials are wrong.";
        }
    }
    else {
        $message = "Provided credentials are wrong.";
    }

    mysqli_stmt_free_result($req);
    mysqli_stmt_close($req);
    mysqli_close($db);
    return $message;
}
?>

<html>
  <head>
    <link rel="stylesheet" href="../css.css">
  </head>
  <?php
   include("../header.php");
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
   include("../footer.php");
   ?>
</html>
