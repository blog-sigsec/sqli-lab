<?php

function login($username, $password)
{
    require_once('config.php');

    $message = "";
    if ($username !== "" && $password !== "")
    {
        # Prepare data
        $user = trim($username);
        $pass = hash('sha256', trim($password), false);

        # We request the user
        $query = "SELECT username, password FROM Users WHERE username='" . $user . "' AND password='" . $pass . "';";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        $count  = mysqli_num_rows($result);

        if ($count == 0) {
            $message = "Invalid Username or Password!";
        }
        else if ($count == 1) {

            # LEVEL 1
            $row = mysqli_fetch_array($result);
            $message = "You are successfully authenticated as : " . $row['username'] . "!";

            /*
            # LEVEL 2 : less injections
            else if (password_verify($pass, $row['password']) == true) {
                # LEVEL 2 : HASHED PASS
                $message = "You are successfully authenticated as : " . $row['username'] . "!";
            }
            else {
                $message = "Invalid Username or Password!";
            }
            */
            # LEVEL 3 : PREPARED REQUESTS


        }
        else {
            $message = "Unknow error, try again later.";
        }

        mysqli_close($db);
        return $message;
    }
}

        /*
          # Prepared request are safe

        $query = "SELECT username, password FROM Users WHERE username = ?";
        $stmt = mysqli_prepare($db, $query);
        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $num = mysqli_stmt_num_rows($stmt);

            if ($num == 0) {
                $message = "Provided credentials are wrong.";
            }
            else if ($num == 1) {
                mysqli_stmt_bind_result($stmt, $db_user, $hash);
                mysqli_stmt_fetch($stmt);
                if (password_verify($pass, $hash)) {
                    $message = "Logged as " . $db_user . " !";
                }
            }
            else {
                $message = "Unknow error, try again later";
            }

            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
        }
        */

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
