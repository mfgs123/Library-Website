
<!-- Logout.php is a page used to end session of the user currently logged in. It also displays a button "Logout" -->
<?php

  //starting session so that webpage has access to session variables like $_SESSION["account"]
  session_start();


  //using !isset() to ensure that user is logged in to display nextpage.php
  //$_SESSION["account"] is only created if the user is logged in, isset is false, the user is not logged in
  if (!(isset($_SESSION["account"]))) 
  {
    //if the user is not logged in and homepage.php is trying to be accessed, they will be redirected to login page
    header("Location: ../php/login.php"); 
  }
  else
  {
    //Else, if the user is logged in, A "hello" message is displayed alongside the user's username.
    //The username is accessed using the session variables $_SESSION["account"]
    echo "Hello";
    echo $_SESSION["account"] ;

  }

  //if button1 'logout' is pressed, 
  //this will trigger a function that destroys session
  if(array_key_exists('button1', $_POST))
  {
    button1();
  }

  //session will be destroyed once the funcion is triggered by the button being pressed
  function button1() 
  {
    session_destroy();
    header("Location: ../index.php");
  }

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
</head>
<body>

<!-- Creating HTML button to confirm logout, if the button is pressed, this will trigger the function to destroy the session
This section will also display a the username which will inform the us which user is being logged out-->
 <section>
    <p1>Confirm logout from user: <?php echo $_SESSION["account"];?> </p1>
    <form method = "post">
    <input type="submit" name="button1" class="button" value="Logout" />
    </form>
</section>
    
</body>
</html>
