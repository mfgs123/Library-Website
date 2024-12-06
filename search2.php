<!-- search2.php will be used to ask the user to search for a book using dropdown menu-->
<?php
  session_start();

  if (!(isset($_SESSION["account"]))) 
  {
    header("Location: ../php/login.php"); 
  }
  else
  {
    /*Connecting to database libDB */
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

   <!-- PHP Code that will first extract the category id from the category "table" that matches the genre entered by user, then
   this category ID is used to search for the corresponding row of data in "books"table and displaying the corresponding books -->
   <?php

      //creating a counter value that will keep track of the number of rows that is being diplayed on the webpage
         //this value will be used later on in this piece of code
      $count = 0;
     
      //The isset() statement is once again used to make sure that a book category value was chosen from the 
      //drop down meny first before running the rest of the code.
      //This ensures that the rest of the code is not run the first time the page is run
     if(isset($_POST['book-categories']))
     {
        $bc = $_POST['book-categories'];

        echo "<br>You selected the category: $bc";

        //This first SQL statement is used to get the category id from categories table that match the genre inserted by the user
        //This is done to then output the corresponding book rows from the table "books" based on the category ID
        $sql = "SELECT CategoryID, Genre FROM categories WHERE Genre = '$bc'";
        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
          
                while($row = $result->fetch_assoc())
                {
                    //placing the category id that match the genre the user inputted into $id
                    $id = $row["CategoryID"];
                }
             
        } 

        
        //This select statement will return the book rows with the same category id as the genre the user inputted
        $sql = "SELECT ISBN,BookTitle, Author, Edition, Year,Reserved FROM books WHERE Category = '$id' ";
        $result = $conn->query($sql);

        //creating a variable that stores the total number of rows returned by select sql statement, 
        //this will be passed to nextpage.php through its parameters when creating the link
        $total = $result->num_rows;

         //this if() statement makes sure that there are more than 0 rows being returned by sql statement
        if($result->num_rows > 0)
        {
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
                   if($row["Reserved"] == "N")
                    {
                        echo "</td><td>";
                        echo ('<a href = "../php/reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve Book</a>');
                       
                    }
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
                     echo "<br>";

                     //making sure that "next page" link is not displayed if 5 rows are outputted and 5 rows is the maximum number of rows being returned by sql statement
                     if ($count != $total)
                     {
                       //the "next page" link is displayed to redirect the user to nextpage2.php to output the rest of the rows
                       //the parameters passed to the nextpage2.php is the $count value which represents the position of the last row displayed (it will always be 5 in this case as this code is only run when $count is 5)
                       //The category id is also passed to recreate the SQL SELECT statement to output the correct book rows
                       //The total number of rows returns by the SQL statament is also passed
                       echo "<a href='../php/nextpage2.php?count=".htmlentities($count)."&categoryID=".htmlentities($id)."&total=".htmlentities($total)."'>Next Page</a>";
                     }
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
                              echo "<p><a href=\"mailto:your-email@your-domain.com\">library@gmail.com</a></p>";
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

            echo "</table>\n";
        } 


      }

   ?>

   <!-- Creating dropdown menu using html and php-->
  <h1> Search for a book below! </h1>
  <section>
   <p>Search by book category: </p>
    <form method = "post">
        <label for = "book-categories">Choose a category:</label>
        <select name="book-categories" id="book-categories">
            <option value= "None">None</option>

            <!-- Using php to ensure that the book categories are retrieved from database-->
            <?php
            //This SQL statament will return the each category genre from the table "categories"  my database "libDB"
                $sql = "SELECT Genre FROM categories";
                $result = $conn->query($sql);

                //The following code is extracting the category genre from each row returned
                //Each genre is placed as a value of the drop down menu
                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $r = $row["Genre"];
                        echo "<option value= \"$r\">$r</option>";

                    }
                }

                //closing connection to database
                $conn->close();        
            ?>
        </select>
        <input type = "submit" name = "submit" value = "Search"/>
        <br>
        <a href="../php/homepage.php">Cancel</a>
    </form>
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