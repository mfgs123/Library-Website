<!-- homepage.php is the webpage the user is first introduced once they are logged in, it displays two buttons containing two links:
1. One for the user to search a book by author or/and title
2. Another for user to search book by category -->

<?php
  
  //starting session so that webpage has access to session variables like $_SESSION["account"]
  session_start();

  //using !isset() to ensure that user is logged in to display homepage
  //$_SESSION["account"] is only created if the user is logged in, isset is false, the user is not logged in
  if (!(isset($_SESSION["account"]))) 
  {
    //if the user is not logged in and homepage.php is trying to be accessed, they will be redirected to login page
    header("Location: ../php/login.php"); 
  }
  else
  {
    //if the user is logged in, homepage.php connects to libDB
    require_once "../database.php";

  }
?>

<!DOCTYPE html>
<html lang = "en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home Page</title>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <!--CSS for the header, button and footer are linked to this php page using <link> and referencing style.css-->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <!-- HTML code for header, displaying navigation bar, header image, welcome text and a 'logged in as' text with the user's username-->
   <header>
   <div id = "welcometext">

          <!-- Acquiring the user's username using the session variable $_SESSION["account"] ;-->
          <?php
            echo "Logged in as ";
            echo $_SESSION["account"] ;
          ?>   
    </div> 
    <nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "navbar-brand">
           <a class = "nav-item nav-link active" href="../php/view_userbooks.php">My Reserved Books</a>
           <a class = "nav-item nav-link active" href="../php/homepage.php">Homepage</a>
           <a class = "nav-item nav-link active" href="../php/logout.php">Logout</a>
        </div>
    </nav>

    <div>
        <h1>Welcome to the library homepage!</h1> 
    </div>
   </header>

   <!--Displaying links in a button format so that the user can either look up by title/author or by dropdown menu-->
   <section>
     <p id="par1">Please click one of the following buttons to search for books: </p>
     <br>
     <button class = "button button1">
        <a id ="firstlink" href="../php/search1.php">Search by Book Tile or/and Author</a>
      </button>
     <br>
     <button class = "button button2">
       <a id = "secondlink" href="../php/search2.php">Search by Category</a>
     </button>
     <br>
     <br>
     <br>
     <br>

   </section>

         
   <!-- html for footer that displays contact info-->
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
