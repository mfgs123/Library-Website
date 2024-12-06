<!-- search1.php will be used to ask the user to search for a author and/or book title-->
<?php
  
  //starting session so that webpage has access to session variables like $_SESSION["account"]
  session_start();


  //using !isset() to ensure that user is logged in to display search1.php
  //$_SESSION["account"] is only created if the user is logged in, isset is false, the user is not logged in
  if (!(isset($_SESSION["account"]))) 
  {
    //if the user is not logged in and search1.php is trying to be accessed, they will be redirected to login page
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
    <!-- HTML code to display 'logged in as' text with the user's username acquired from session variable $_SESSION["account"] -->
   <div id = "welcometext">
          <?php
            echo "Logged in as ";
            echo $_SESSION["account"] ;
          ?>   
    </div> 

    <!-- HTML code to display the navigation bar with corresponding links-->
    <nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "navbar-brand">
           <a class = "nav-item nav-link active" href="../php/view_userbooks.php">My Reserved Books</a>
           <a class = "nav-item nav-link active" href="../php/homepage.php">Homepage</a>
           <a class = "nav-item nav-link active" href="../php/logout.php">Logout</a>
        </div>
    </nav>
 
     <!-- HTML code to display the webpage title -->
    <div>
        <h1>Welcome to the library homepage!</h1> 
    </div>
   </header>

   <!-- Form that will ask user to enter book title and or author -->
   <h1> Search for a book below! </h1>
   <section>
     <p> Search by book title and/or author: </p>
     <form method = "post">
        <p>Book Title: <input type = "text" name = "BTitle"></p>
        <p>Author: <input type = "text" name = "Author"></p>
        <p><input type = "submit" name = "submit" value = "Search"/>
        <a href="../php/homepage.php">Cancel</a></p>
    </form>
   </section>

   <br>
   
   <section>

   <br>
   <br>

    <section>
      <?php

         //creating a counter value that will keep track of the number of rows that is being diplayed on the webpage
         //this value will be used later on in this piece of code
         $count = 0;
          


       /*Isset() function is once again used to make sure that either  the title or author fields are first filled in before the code used to 
        search and output the matching books is run.
        This means that in the first time the page is run, this code will not run*/
        if (isset($_POST['BTitle']) || isset($_POST['Author']))
          {
              $t = $_POST['BTitle'];
              $a = $_POST['Author'];
              
              //creating an sql statement that will return the rows from table "books" that contains the data inputted by user in either book title and/or author fields
              //the user can either fill one these fields or both in the same search

              //if the user searches for the title "co", the sql statement will return books that contain "co" inside its title

              //however, if the user searches for the title "co" and author "alicia", this statement will only return the rows
              //that contain both "ca" in the title and an "alicia" in the author's name
              $sql = "SELECT ISBN, BookTitle, Author, Edition, Year,Reserved FROM books WHERE BookTitle LIKE '%$t%' AND Author LIKE '%$a%'";
              $result = $conn->query($sql);

              //creating a variable that stores the total number of rows returned by select sql statement, this will be passed to nextpage.php through its parameters when creating the link
              $total = $result->num_rows;
              


              //this if() statement makes sure that there are more than 0 rows being returned by sql statement
              if($result->num_rows > 0)
              {
                //outputting data of each row in table form
                echo "<table border ='1'>";
                
                //this code is outputting one book row at a time
                //i am keeping track of the number of rows being displayed by adding one to the count value each time a new row is displayed
                  while($row = $result->fetch_assoc())
                  {
                      $count += 1;
                          echo "<tr><td>";
                          echo ($row["BookTitle"]);
                          echo "</td><td>";
                          echo ($row["Author"]);
                          echo "</td><td>";
                          echo ($row["Edition"]);
                          echo "</td><td>";
                          echo ($row["Year"]);
                          echo "</td><td>";
                          echo ($row["Reserved"]);
                          //if book is not reserved yet, a link is displayed, redirecting the user to reserve.php, to confirm reservation
                          if($row["Reserved"] == "N")
                          {
                              echo "</td><td>";
                              echo ('<a href = "../php/reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve Book</a>');
                          }
                          //if row is already researved, it displays corresponding message so that user cannot reserve it
                          else
                          {
                              echo "</td><td>";
                              echo "Already Reserved";
                          }
                          echo "</tr>\n";
  
                      //if 5 rows are displayed, i am first displaying a "next page" link and the footer
                      //Then i am exiting the if($result->num_rows > 0) by making "$result->num_rows = 0;" 
                      //so that the rest of the rows are not outputted in this page
                      if ($count == 5)
                      { 
                        //a "next page" link is displayed on the webpage to redirect user to nextpage.php to display rest of rows, using href="" i am passing to nextpage.php the following parameteres:
                        // the "count=" attribute is passing the count value (5) so that I know from which postion to output the rest of the book rows
                        //The paramteres "&btitle=" and "&author=" are passing the data inserted by the user in both the author and title fields so we can recreate the sql statament in nextpage.php
                        //also passing the total number of rows returned by sql statement through "&total="
                          echo "<br>";
                          //making sure that "next page" link is not displayed if 5 rows are outputted and 5 rows are the maximum number of rows being returned by sql statement
                          if ($count != $total)
                          {
                            echo "<a href='../php/nextpage.php?count=".htmlentities($count)."&btitle=".htmlentities($t)."&author=".htmlentities($a)."&total=".htmlentities($total)."'>Next Page</a>";
                          }
                          //closing the table tag if the number of rows being returned is 5 or more
                          echo "</table>\n";
                          //when we exit the loop, the rest of the html footer code is not run, so i am placing the footer code inside the php section before
                          //making "$result->num_rows = 0;" so that the footer is also displayed when the next page link is displayed
                          echo "<footer>";
                         echo "<div class=\"contact\" id=\"contact\">";
                           echo "<div class=\"bg-dark\">";
                         echo "<div class=\"container\">";
                            echo "<div class=\"row\">";
                             echo "<div class=\"col-lg-8 col-lg-offset-2 text-center\">";
                               echo "<h1>To Get In Touch!</h1>";
                               echo "<hr class=\"primary\"></hr>";
                             echo "<p class=\"my-font\">If you have any queries or concerns, you can contact us through email or by call. Thank you!</p>";
                             echo "</div>";

                             echo "<div class=\"padded\">";
                               echo "<div class=\"col-lg-8 col-lg-offset-2 text-center\">";
                               echo "<i class=\"fas fa-phone\"></i>";
                               echo "<p>99999999</p>";
                               echo "</div>";

                               echo "<div class=\"col-lg-4 text-center\">";
                                  echo "<i class=\"fa fa-envelope-o fa-3x sr-contact\"></i>";
                                  echo "<p><a href=\"mailto:your-email@your-domain.com\">gfgfgfg@gmail.com</a></p>";
                               echo "</div>";
                               echo "</div>";
                             echo "</div>";
                             echo "</div>";
                         echo "</div>";
                         echo "</div>";
                            echo "<p>©2024 Created by Maria Granados</p>";
                         echo "</footer>";

                         //once the nextpage link and footer are displayed, i am exiting and stopping the rest of the rows from being displayed by making $result->num_rows = 0;
                       $result->num_rows = 0;
                      }
  
                  }
                  //closing the table tag, if the number of rows being returned is less than 5
                echo "</table>\n";
  
              }
               //if there are no rows returned by the sql statement, a message is displayed "0 results"
              else
              {
                  echo "0 results";
              }

          }

          //closiing connection to db
          $conn->close();

      ?>
       
    </section>


  
  <!-- HTML code to display footer if the number of rows the sql statement returns is smaller than 5-->
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