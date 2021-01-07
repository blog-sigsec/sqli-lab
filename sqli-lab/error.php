<?php

function login($user, $pass)
{
    require_once('config.php');

    $message = "";

    if ($user !== "")
    {
        $username = trim($user);
        $query = "SELECT username FROM Users WHERE username='" . $username . "'";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        $count  = mysqli_num_rows($result);

        if ($count > 0) {
            $row = mysqli_fetch_array($result);
            $message = "Users " . $row['username'] . " exist !";
        }
    }
    else {
        $message = "Give me a user to search for.";
    }
    mysqli_close($db);
    return $message;
}
?>

<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>
  <body>
       <div>
	 <form id="search" method="post" action="" accept-charset='UTF-8'>
	   <table border="0" cellpadding="5"  align="center">
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
                  echo login($_POST['username'], $_POST['password']);
              }
      ?>
    </div>
  </body>
</html>
