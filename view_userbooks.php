<!-- view_userbooks.php is a php page that will allow the users to view their reserved books and cancel any reservation -->

<?php

   //starting session so that webpage has access to session variables like $_SESSION["account"]
  session_start();

  //using !isset() to ensure that user is logged in to display view_userbooks.php
  //$_SESSION["account"] is only created if the user is logged in, isset is false, the user is not logged in
  if (!(isset($_SESSION["account"]))) 
  {
    //if the user is not logged in and view_userbooks.php is trying to be accessed, they will be redirected to login page
    header("Location: ../php/login.php"); 
  }
  else
  {
    /*Else, Connecting to database libDB */
    require_once "../database.php";
 
  }
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
   <header>
   <div id = "welcometext">
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

   <!--Connecting to the database and more specifically to the tables "reservations" and "books" to extract the book title, ISBN 
     ,username and reserved date though a join statement and displaying these rows on the webpage-->
   <section>
     <p>These are your reserved books: </p>     
    <?php
        //require_once "../database.php";
        if (isset($_SESSION["account"]))
        {
          
          //acquiring the user's username through this session variable
          $acc = $_SESSION["account"];
          
          //using a join statement to extract the BookTitle and ISBN values from the table "books" using the ISBN value as a common attribute  
          //that has been reserved by the logged in user
          $sql = "SELECT BookTitle, ISBN, Username, ReservedDate FROM reservations JOIN books USING (ISBN) WHERE Username = '$acc' ";
          $result = $conn->query($sql);

          if($result->num_rows > 0)
          {
            echo "<table border ='1'>";
             while($row = $result->fetch_assoc())
             {
                echo "<tr><td>";
                echo ($row["BookTitle"]);
                echo "</td><td>";
                echo ($row["ISBN"]);
                echo "</td><td>";
                echo ($row["Username"]);
                echo "</td><td>";
                echo ($row["ReservedDate"]);
                echo "</td><td>";
                //link that will allow the user to cancel a specfic book reservation, we are passing the ISBN value to know which book to remove from "reservations" table in db
                echo ('<a href = "../php/cancelreserve.php?id='.htmlentities($row["ISBN"]).'">Cancel Reservation</a>');
                echo "</tr>\n";
             }
             echo "</table>\n";
          }
        
        }

        //closing connection to database
        $conn->close();        
    ?>

   

   </section>

  <br>
  <br>
  
  <!-- HTML code used to display the page footer-->
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