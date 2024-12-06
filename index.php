<!-- Index.php is the page user is first introduced to before they are logged in, it is used to ask user to register or login -->
<!DOCTYPE html>
<html lang = "en">
<head>

    <style>

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home Page</title>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assig/css/style.css">
</head>
<body>

    <?php 

      /*PHP code to connect to database 'lidDB' using the php file "database.php" */
      require_once "database.php";
    
      //closing connection to db
      $conn->close();
      
    ?>

    <!-- HTML code to creave navigation bar (displays links for the index, register and login page) and title -->
  <header>
    <nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "navbar-brand">
           <a class = "nav-item nav-link active" href="../assig/index.php">Home</a>
           <a class = "nav-item nav-link active" href="../assig/php/register.php">Register</a>
           <a class = "nav-item nav-link active" href="../assig/php/login.php">Login</a>
        </div>
    </nav>

    <!-- HTML code to display the header title -->
    <div>
        <h1>Welcome to the library homepage!</h1> 
    </div>
  </header>

   

  <!-- HTML code that displays 3 card holders containing images
       of examples of books user can reserve once logged in -->
  <h1>Please login or register to reserve books such as: </h1>
  <div class = "container">
      <div id = "image1class" class ="card-holder">
        <img src="../assig/images/image1.jpg" alt ="Image of davinci code book">
        <h3>DaVinci Code<h3>
      </div>
      <div class = "card-holder">
        <img src="../assig/images/image2.jpg" alt ="Image of the armour of light book">
        <h3>The Armor Of Light<h3>
      </div>
      <div class = "card-holder">
        <img id="image3" src="../assig/images/image3.jpg" alt ="Image of Darwin book">
        <h3>Darwin<h3>
      </div>
  </div> 

    
  <!-- HTML code for the footer of webpage, it displays a
  sample telephone number and sample email for the user to contact-->
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
          <p><a href="mailto:your-email@your-domain.com">gfgfgfg@gmail.com</a></p>
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
