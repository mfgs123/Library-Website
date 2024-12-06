<!-- nextpage.php is used to display the rest of the rows using the parameters passed through the link in search1.php
These parameters are the count variable, that will determine from which postion to output the rest of the book rows, 
I am also using the $btitle and &author values (data inputed by user in search1.php form) to recreate the SQL statement to display the rest of the rows -->
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


  <br>
  <br>

  <section>

    <?php

        //acquring the count value which was passed as a parameter inside the <link> tag in search1.php
        //it serves as the position from each the next 5 rows are displayed, it will be used in the select statement
        $count = $_GET['count'];

        //creating a new count variable $nc which will serve as a counter decresing in value everytime a new row is outputted to store the positon used for the previous page link
        //this is used so that the user can go back to previous page and have access to the previous 5 rows displayed
        $nc = $count;
        
       
       if (isset($_GET['btitle']) || isset($_GET['author']))
        {
           //acquiring the values passed as parameters in the <link> tag in search1.php
           //the book title and author data (inputed by user in the form) is stored in php variables $t and $a
           // the total number of rows returned by statement is places into $total
            $t = $_GET['btitle'];
            $a = $_GET['author'];
            $total = $_GET['total'];

            
            //creating a new variable called $newcount (which is $count added 5)
            //so that as $count increases by 1 everytime a new row is outputted, once it reaches $newcount 
            //it can exit loop by  placing "$result->num_rows = 0;" and display next link;
            $newcount  = $count + 5;


            //creating an sql statement that will return the rows from table "books" that contains the data inputted by user in either book title and/or author fields
            //the user can either fill one these fields or both in the same search

            //unlike search1.php, this sql statement contains "limit 5 offset $count" Offset is used to display the next rows from a particular position, since $count is used as
            //the postiion of the last low displayed, offset will ignore the first few rows until it reaches the postion given ($count) and display only 5 rows (achieved using limit 5)
            //limit 5 only allows 5 rows to be displayed at a time
            $sql = "SELECT ISBN, BookTitle, Author, Edition, Year,Reserved FROM books WHERE BookTitle LIKE '%$t%' AND Author LIKE '%$a%' LIMIT 5 OFFSET $count ";
            $result = $conn->query($sql);



            //this if() statement makes sure that there are more than 0 rows being returned by sql statement
            if($result->num_rows > 0 )
            {
                //outputting data of each row in table form
                echo "<table border ='1'>";
                while($row = $result->fetch_assoc())
                {
                  //this code is outputting one book row at a time
                  //i am keeping track of the number of rows being displayed by adding one to the count value each time a new row is displayed
                  //i am also keeping track of the original postion of the count value by taking one away from $nc (equal to the original value of $count), so that the user can access previous page rows
                    $nc -= 1;
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
                         //if book already reserved, an "already reserved" message is displayed
                         else
                         {
                             echo "</td><td>";
                             echo "Already Reserved";
                         }
                         echo "</tr>\n";
 
                         //Once 5 rows have been displayed, we will be displaying the footer and next link.
                         //In this case, the "next link" will redirect the user to this same page (nextpage.php), however it will pass
                         //the updated value of count (as 5 more rows were outputted).
                         //So that once the user presses the link, the sql statement will run the offset element with count added 5.
                         //to display the next five rows from the updated postion
                     if ($count == $newcount)
                     { 
                         //new is storing the position of the previous 5 rows
                         $new = $nc;
                         //echo "<br>The new count you passed is $new";
                         echo "<br>";
                         //the count value will only be displayed as long as the count is not equal to the total number of rows outputted by sql statement from search1.php
                         //so that once count reaches the total number, next page link wont be displayed leading the user to an empty page with no rows
                         if ($count != $total)
                         {
                           echo "<a href='../php/nextpage.php?count=".htmlentities($count)."&btitle=".htmlentities($t)."&author=".htmlentities($a)."&total=".htmlentities($total)."'>Next Page</a>";
                         }
                         else
                         {
                           echo "No Next Page";
                         }
                        
                         //$new is storing the intial position to display the last 5 rows, previouspage link redirects the user to this same page "nextpage.php" but
                         //with a decreased count value, to display the previous rows since the position was decreased by 5
                         //making sure that it does not pass below 0, as the first row has a positon of 1
                         if ($new >= 0)
                         {
                           //previous link will pass the positon the start of the previous 5 rows as "$new".
                           echo "<br>";
                           echo "<a href='../php/nextpage.php?count=".htmlentities($new)."&btitle=".htmlentities($t)."&author=".htmlentities($a)."&total=".htmlentities($total)."'>Previous Page</a>";
                         }
                         echo "<br>";
                         echo "<br>";
                         //displaying link so that user can return to homepage
                         echo "<a href='../php/homepage.php'>Go back to homepage</a>";
                         //closing the table tag if the number of rows is 5
                         echo "</table>\n";
                        //when we exit the loop, the rest of the html footer code is not run, so i am placing the footer code inside the php section before
                          // making "$result->num_rows = 0;" 
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
                                  echo "<p><a href=\"mailto:your-email@your-domain.com\">library@gmail.com</a></p>";
                               echo "</div>";
                               echo "</div>";
                             echo "</div>";
                             echo "</div>";
                         echo "</div>";
                         echo "</div>";
                            echo "<p>©2024 Created by Maria Granados</p>";
                         echo "</footer>";
                         $result->num_rows = 0;
                     }

                }
                echo "</table>\n";

            }

        }
        //closiing connection to db
        $conn->close();
    ?>
  </section>

  <!-- Displaying footer if the number of rows displayed is less than 5-->
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