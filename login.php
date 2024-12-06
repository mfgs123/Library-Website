<!--login.php is a php page that will ask for user to login using username and password-->
<?php

  /*Starting a session*/
  session_start();


  /* Setting a session variable called 'account' to store the username of user 
  login in so it can be remembered across the rest of php pages*/
  unset($_SESSION["account"]);
?>


<!DOCTYPE html>
<html lang = "en">
<head>

    <style>

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home Page</title>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>


   
    <?php 

      //Using require_once to connect to database
      require_once "../database.php";

      //Using isset() to make sure user has entered data into these fields before running the code used
      //to check whether the username and password exist in the database before redirecting user to homepage.php

      //Isset() prevents the code to run the first time page is loaded (since all fields would be blank)
      if (isset($_POST['Username']) && isset($_POST['Password']))
      {
        $u = $_POST['Username'];
        $p = $_POST ['Password'];

        //sql statement is used to extract all the rows from table user in lidDB 
        $sql = "SELECT Username, Password FROM users";
        $result = $conn->query($sql);
        

        //The below code is transversing through the rows exctracted using above sql to check if the username and password entered by the user exists
        if($result->num_rows > 0)
        {
          //fetching username and password in each row 
          while($row = $result->fetch_assoc())
          {
              //Comparing usernames and password in database to the ones entered by user
              /* If user is found in database, user is sent to library homepage.php and their account username
               is saved into session variable $_SESSION["account"] so it can be accessed by other pages*/
              if ( (($row["Username"]) == $u) && (($row["Password"]) == $p))
              {
                  $_SESSION["account"] = $u;
                  $_SESSION["success"] = "Logged In.";
                  header("Location: ../php/homepage.php"); 

              }
              else
              {
                //creating a session variable $_SESSION["error"] to store a message that will be displayed if the user and password cannot be found in databse
                $_SESSION["error"] = "Incorrect username or password";
              }
          }
      
        }
        //displaying message if there no users stored in database
        else
        {
          echo "0 users in database";
        }
        
      }

     //closing connection to db
      $conn->close();
      
    ?>

    
<!-- Creating the navigation bar inside the header section-->
   <header>
    <nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "navbar-brand">
           <a class = "nav-item nav-link active" href="../index.php">Home</a>
           <a class = "nav-item nav-link active" href="../php/register.php">Register</a>
           <a class = "nav-item nav-link active" href="../php/login.php">Login</a>
        </div>
    </nav>

    <!--HTML code to display the webpgage title-->
    <div>
        <h1>Welcome to the library homepage!</h1> 
    </div>
   </header>


   <!-- Creating HTML login form that asks for user's username and password -->
   <section>
   <p>Please login below:</p>
   <?php
      
    //The variable $_SESSION["error"] will be created if the user is not found by the system, so if it is created, this will make isset() true
    //and trigger the code inside isset() so that it display a red message "Incorrect username or password"
     if (isset($_SESSION["error"]))
     {
       echo ('<p style = "color:red">Error:' . $_SESSION["error"] . "</p>\n");

       //once error message is displaye, we remove $_SESSION["error"] variable
       unset($_SESSION["error"]);

     }

   ?>
   <!-- HTML login form-->
   <form method = "post">
        <p>Username:<input type = "text" name = "Username"></p>
        <p>Password:<input type = "password" name = "Password" minlength = '6' maxlength = '6'></p>
        <p><input type = "submit" name = "submit" value = "Login"/>
        <a href="../index.php">Cancel</a></p>
    </form>

      
   </section>

  <!-- Creating footer at the end of page that will provide user with information-->
  <footer>
  <div class="contact" id="contact">
    <div class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 text-center">
        <h1>To Get In Touch!</h1>
        <hr class="primary"></hr>
      <p class="my-font">If you have any queries or concerns, you can contact
        us through email or by call. Thank you!</p>
      </div>

      <div class="padded">
       <div class="col-lg-8 col-lg-offset-2 text-center">
       <i class="fas fa-phone"></i>
       <p>99999999</p>
       </div>

       <div class="col-lg-4 text-center">
         <i class="fa fa-envelope-o fa-3x sr-contact"></i>
         <p><a href="mailto:your-email@your-domain.com">library@gmail.com</a></p>
       </div>
       </div>
      </div>
      </div>
   </div>
  </div>
    <p>©2024 Created by Maria Granados</p>
  </footer>

<script src="../javascript/script.js"></script>
</body>
</html>
