<?php

function    create($username, $password, $confirmation) {

    $message = "";
    require_once('config.php');

    $user = trim($username);
    $pass = trim($password);
    $confirm = trim($confirmation);

    if ($username === "" || $password === "") {
        $message = "I need username, password and confirmation";
        mysqli_close($db);
        return $message;
    }

    if ($pass !== $confirm) {
        $message = "Password and confirmation doesn't match. Try again";
        mysqli_close($db);
        return $message;
    }

    $query = "SELECT username, password FROM Users WHERE username = ?";
    if (($req = mysqli_prepare($db, $query) === false)) {
        $message = "Uknow error, try again later.";
        mysqli_close($sb);
        return $message;
    }

    mysqli_stmt_bind_param($req, "s", $user);
    mysqli_stmt_execute($req);
    mysqli_stmt_store_result($req);
    $num = mysqli_stmt_num_rows($req);
    if ($num > 0) {
        mysqli_stmt_free_result($req);
        mysqli_stmt_close($req);
        $message = "Username already taken.";
        return $message;
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $query = "INSERT INTO Users (username, password) VALUES (?, ?)";
    if (($req = mysqli_prepare($db, $query))) {
        mysqli_stmt_bind_param($req, "ss", $user, $hash);
        if (mysqli_stmt_execute($req) === true) {
            $message = "Account created ! You can now login as : '" . $user . "'.";
        }
        else {
            $message = "Unknow error. Try again later";
        }
    }
    else {
        $message = "Unknow error. Try again later.";
    }
    mysqli_stmt_free_result($req);
    mysqli_stmt_close($req);
    mysqli_close($db);
    return $message;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../css.css">
  </head>

  <?php
   include("../header.php");
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
  <?php
   include("../footer.php");
   ?>
</html>
