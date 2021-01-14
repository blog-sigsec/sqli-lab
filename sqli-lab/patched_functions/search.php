<?php

function search($username)
{
    require_once('config.php');
    $message = "";

    $user = trim($username);
    if ($username === "") {
        $message = "Fill username please.";
        mysqli_close($db);
    }

    $query = "SELECT username FROM Users WHERE username = ?";
    if (($req = mysqli_prepare($db, $query)) === false) {
        $message = "Uknow error, try again later.";
        mysqli_close($sb);
        return $message;
    }

    mysqli_stmt_bind_param($req, "s", $user);
    mysqli_stmt_execute($req);
    mysqli_stmt_store_result($req);
    $num = mysqli_stmt_num_rows($req);
    if ($num === 0) {
        $message = "Unknow user.";
    }
    else if ($num === 1) {
        mysqli_stmt_bind_result($req, $db_user);
        mysqli_stmt_fetch($req);
        $message = "User " . $db_user . " exist !";
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
  <?php
   include("../footer.php");
   ?>
</html>
