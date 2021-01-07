<?php

function search($user)
{
    require_once('config.php');
    $message = "";
    if ($user !== "")
    {
        $username = trim($user);
        $query = "SELECT username FROM Users WHERE username='" . $username . "'";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        $count  = mysqli_num_rows($result);

        if ($count != 1) {
            $message = "Unknow user :(";
        } else {
            $row = mysqli_fetch_array($result);
            $message = "User " . $row['username'] . " exist !";
        }
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
