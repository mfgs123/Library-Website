<!--register.php will contain a form so user can register into the library page-->
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

      
      //linking php file to connect to database
      require_once "../database.php";
      
      //making sure the submit post was clicked before validating information in form
      if (($_POST['submit']))
      {

        //if not all fields are entered, the webpage displays an error message
        if (empty($_POST['Username']) || empty($_POST['Password']) || empty($_POST['confirm_password']) || empty($_POST['FirstName']) || empty($_POST['Surname']) || empty($_POST['AddressLine1']) || empty($_POST['AddressLine2']) || empty($_POST['City']) || empty($_POST['Telephone']) || empty($_POST['Mobile']))
        {
          echo "<br>Please fill out all fields!<br>";
        }
        else
        {
          //acquring user details from the forms and placing it into php variables to perform server side validation
          $u = $_POST['Username'];
          $p = $_POST['Password'];
          $cp = $_POST['confirm_password'];
          $f = $_POST['FirstName'];
          $s = $_POST['Surname'];
          $a1 = $_POST['AddressLine1'];
          $a2 = $_POST['AddressLine2'];
          $c = $_POST['City'];
          $t = $_POST['Telephone'];
          $m = $_POST['Mobile'];
          $user_exists = FALSE;


          //searching for username entered by user in form to see if it already exists in the database
          $sql = "SELECT Username FROM users";
          $result = $conn->query($sql);

          if($result->num_rows > 0)
          {
            while($row = $result->fetch_assoc())
            {
              if ($row["Username"] == $u)
              {
                //if user_exists becomes true, this will create an error message further on in the code
                $user_exists = TRUE;
              }
            }
          }


          //The below statements are used to validate the data inputted by user

          //It ensures that the mobile numbers inserted are numeric and 10 characters long
          //It also ensures that the password is 6 characters long and that both the "confirm password" and "password" fields match
          //It also checks that the username doesn't already exist in the database

          //An error message is displayed if any of these is not met
          if ((!is_numeric($t)) || (!is_numeric($m)) || ($user_exists == TRUE) || (strlen($t) != 10) || (strlen($m) != 10) || (strlen($p) != 6) || ($p != $cp))
          {
            if ((!is_numeric($t)) || (!is_numeric($m)))
            {
              echo "<br><br>Both telephone and mobile must be numeric!";
            }

            if ($user_exists == TRUE)
            {
              echo "<br><br>Username already exists! Please login!";
            }

            if ((strlen($t) != 10) || (strlen($m) != 10) )
            {
              echo "<br><br>Both telephone and mobile must 10 characters long!";
            }

            if ((strlen($p) != 6))
            {
              echo "<br><br>The password must be 6 characters long!";
            }

            if ($p != $cp)
            {
              echo "<br><br> The passwords do not match";
            }

          }
          //if validation doesn't detect any errors, user is successfully inserted into database and message is displayed
          else
          {
            $sql = "INSERT INTO users (Username, Password, FirstName, Surname,AddressLine1,AddressLine2,City,Telephone,Mobile) VALUES
                  ('$u' , '$p', '$f', '$s','$a1','$a2','$c','$t','$m')";

              if ($conn->query($sql) === TRUE)
              {
                  echo "<br>";
                  echo "New Record created succesfully";
              }
              else
              {
                  echo "<br>";
                  echo "Error: " . $sql . "<br>" . $conn->error;
              }
          }
          
        }
      }
      else
      {
        //echo "<br> All fields were not filled in";
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

    <!-- HTML code to display the header title -->
    <div>
        <h1>Welcome to the library homepage!</h1> 
    </div>
   </header>


   <!-- Creating HTML form that that asks for user information so they can register into the library system -->
   <section>

   <p>Please register below:</p>
   <form method = "post">
        <p>Username:<input type = "text" name = "Username"></p>
        <p>Password:<input type = "password" name = "Password" placeholder = "Password" id = "password"></p>
        <p>Confirm Password:<input type = "password" placeholder = "Confirm Password" id = "confirm_password" name = "confirm_password"></p>
        <p>First Name:<input type = "text" name = "FirstName"></p>
        <p>Last Name:<input type = "text" name = "Surname"></p>
        <p>Address Line 1:<input type = "text" name = "AddressLine1"></p>
        <p>Address Line 2:<input type = "text" name = "AddressLine2"></p>
        <p>City:<input type = "text" name = "City"></p>
        <p>Telephone:<input type = "tel" name = "Telephone"></p> 
        <p>Mobile:<input type = "tel" name = "Mobile"></p>
        <p><input type = "submit" name = "submit" value = "Register"/>
        <a href="../index.php">Cancel</a></p>
    </form>

      
   </section>

  <!-- Creating footer at the end of page that will provide user with infp-->
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

</body>
</html>
